import os
import re
from typing import Any, Dict, List, Tuple

import numpy as np
import pandas as pd
import matplotlib.pyplot as plt

import gradio as gr
import joblib
from imblearn.over_sampling import RandomOverSampler
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.naive_bayes import MultinomialNB
from sklearn.model_selection import train_test_split
from sklearn.metrics import (
    accuracy_score,
    precision_score,
    recall_score,
    f1_score,
    confusion_matrix,
)

# -----------------------------
# Helpers
# -----------------------------
REQUIRED_COLUMNS = ["content", "score", "sentiment"]

# Global app state
app_state = {"model": None, "vectorizer": None, "labels": None}

# Load pretrained model & vectorizer kalau ada
if os.path.exists("tfidf_vectorizer.pkl") and os.path.exists("naive_bayes_model.pkl"):
    try:
        app_state["vectorizer"] = joblib.load("tfidf_vectorizer.pkl")
        app_state["model"] = joblib.load("naive_bayes_model.pkl")
        if hasattr(app_state["model"], "classes_"):
            app_state["labels"] = list(app_state["model"].classes_)
        print("✅ Pre-trained model dan vectorizer berhasil dimuat.")
    except Exception as e:
        print(f"⚠️ Gagal memuat model/vectorizer: {e}")


def validate_dataframe(df: pd.DataFrame) -> Tuple[bool, str]:
    missing = [c for c in REQUIRED_COLUMNS if c not in df.columns]
    if missing:
        return False, f"Kolom wajib tidak ditemukan: {missing}. Pastikan ada kolom {REQUIRED_COLUMNS}."
    if df["sentiment"].nunique() < 2:
        return False, "Kolom 'sentiment' minimal harus memiliki 2 kelas (mis. 'positive' dan 'negative')."
    if df["content"].isna().all():
        return False, "Semua nilai pada kolom 'content' kosong."
    return True, "OK"


def read_table(file_obj) -> pd.DataFrame:
    if file_obj is None:
        raise ValueError("File belum diunggah.")
    _, ext = os.path.splitext(file_obj.name.lower())
    if ext in {".xlsx", ".xls"}:
        return pd.read_excel(file_obj.name)
    if ext == ".csv":
        return pd.read_csv(file_obj.name)
    raise ValueError("Format file tidak didukung. Gunakan .xlsx, .xls, atau .csv.")


def train_and_evaluate(df: pd.DataFrame, test_size: float = 0.2, random_state: int = 42):
    X = df["content"].astype(str).values
    y = df["sentiment"].astype(str).values

    stratify_y = y if len(np.unique(y)) > 1 else None
    X_train, X_test, y_train, y_test = train_test_split(
        X, y, test_size=test_size, random_state=random_state, stratify=stratify_y
    )

    # Vectorizer
    vectorizer = TfidfVectorizer(max_features=10000, ngram_range=(1, 2))
    X_train_vec = vectorizer.fit_transform(X_train)
    X_test_vec = vectorizer.transform(X_test)

    # 🔹 Balancing dengan RandomOverSampler
    ros = RandomOverSampler(random_state=random_state)
    X_train_res, y_train_res = ros.fit_resample(X_train_vec, y_train)

    # Model
    model = MultinomialNB()
    model.fit(X_train_res, y_train_res)

    # Evaluasi
    y_pred = model.predict(X_test_vec)
    metrics = {
        "accuracy": float(accuracy_score(y_test, y_pred)),
        "precision_weighted": float(
            precision_score(y_test, y_pred, average="weighted", zero_division=0)
        ),
        "recall_weighted": float(
            recall_score(y_test, y_pred, average="weighted", zero_division=0)
        ),
        "f1_weighted": float(
            f1_score(y_test, y_pred, average="weighted", zero_division=0)
        ),
    }

    labels = sorted(list({*np.unique(y_test), *np.unique(y_pred)}))
    cm = confusion_matrix(y_test, y_pred, labels=labels)

    # hasil prediksi test set → hanya content + prediksi
    full_pred_df = pd.DataFrame(
        {
            "content": X_test,
            "predicted_sentiment": y_pred,
        }
    )

    return {
        "model": model,
        "vectorizer": vectorizer,
        "labels": labels,
        "metrics": metrics,
        "cm": cm,
        "preview_df": full_pred_df.head(5),  # hanya 5 data preview
        "full_pred_df": full_pred_df,  # semua hasil
        "test_records": len(y_test),
        "train_records": len(y_train),
    }


def plot_confusion_matrix(cm: np.ndarray, labels: List[str], title: str):
    fig = plt.figure(figsize=(5, 4))
    ax = fig.add_subplot(111)
    im = ax.imshow(cm, interpolation="nearest", cmap="Blues")
    ax.figure.colorbar(im, ax=ax)
    ax.set(
        xticks=np.arange(cm.shape[1]),
        yticks=np.arange(cm.shape[0]),
        xticklabels=labels,
        yticklabels=labels,
        ylabel="True Label",
        xlabel="Predicted Label",
        title=title,
    )
    for i in range(cm.shape[0]):
        for j in range(cm.shape[1]):
            ax.text(j, i, format(cm[i, j], "d"), ha="center", va="center")
    fig.tight_layout()
    return fig


def save_excel(full_pred_df: pd.DataFrame, metrics: Dict[str, Any], directory: str, suffix: str) -> str:
    os.makedirs(directory, exist_ok=True)
    out_path = os.path.join(directory, f"sentiment_results_{suffix}.xlsx")
    with pd.ExcelWriter(out_path, engine="xlsxwriter") as writer:
        full_pred_df.to_excel(writer, index=False, sheet_name="predictions_full")
        m = pd.DataFrame([metrics])
        m.to_excel(writer, index=False, sheet_name="metrics")
    return out_path


def _metrics_markdown(result: Dict[str, Any], label: str) -> str:
    pred_counts = result["full_pred_df"]["predicted_sentiment"].value_counts(normalize=True) * 100
    distrib_text = "\n".join(
        [f"- {sentiment}: {pct:.2f}%" for sentiment, pct in pred_counts.items()]
    )
    metrics_md = (
        f"## {label}\n\n"
        f"**Model:** Naive Bayes\n\n"
        f"**Records:** Train = {result['train_records']}, Test = {result['test_records']}\n\n"
        f"**Accuracy:** {result['metrics']['accuracy']:.4f}\n\n"
        f"**Precision:** {result['metrics']['precision_weighted']:.4f}\n\n"
        f"**Recall:** {result['metrics']['recall_weighted']:.4f}\n\n"
        f"**F1-score:** {result['metrics']['f1_weighted']:.4f}\n\n"
        f"### 📊 Prediksi:\n{distrib_text}"
    )
    return metrics_md


def handle_two_files(file_obj_a, file_obj_b):
    if file_obj_a is None or file_obj_b is None:
        return (
            gr.update(value="Belum ada dua file diunggah."),
            gr.update(visible=False),
            gr.update(visible=False),
            None,
            None,
            gr.update(visible=False),
            gr.update(visible=False),
            None,
            None,
        )

    try:
        df_a = read_table(file_obj_a)
        df_b = read_table(file_obj_b)
    except ValueError as exc:
        return (
            gr.update(value=f"❌ {exc}"),
            gr.update(visible=False),
            gr.update(visible=False),
            None,
            None,
            gr.update(visible=False),
            gr.update(visible=False),
            None,
            None,
        )

    ok_a, msg_a = validate_dataframe(df_a)
    ok_b, msg_b = validate_dataframe(df_b)
    if not ok_a or not ok_b:
        msg = "\n".join(
            [
                f"File A: {'OK' if ok_a else msg_a}",
                f"File B: {'OK' if ok_b else msg_b}",
            ]
        )
        return (
            gr.update(value=f"❌ {msg}"),
            gr.update(visible=False),
            gr.update(visible=False),
            None,
            None,
            gr.update(visible=False),
            gr.update(visible=False),
            None,
            None,
        )

    # Training
    result_a = train_and_evaluate(df_a)
    result_b = train_and_evaluate(df_b)

    # Simpan model terakhir agar prediksi manual tetap bisa digunakan.
    app_state["model"] = result_b["model"]
    app_state["vectorizer"] = result_b["vectorizer"]
    app_state["labels"] = result_b["labels"]

    metrics_md_a = _metrics_markdown(result_a, "Hasil File A")
    metrics_md_b = _metrics_markdown(result_b, "Hasil File B")

    cm_fig_a = plot_confusion_matrix(result_a["cm"], result_a["labels"], "Confusion Matrix (File A)")
    cm_fig_b = plot_confusion_matrix(result_b["cm"], result_b["labels"], "Confusion Matrix (File B)")

    excel_path_a = save_excel(result_a["full_pred_df"], result_a["metrics"], ".", "file_a")
    excel_path_b = save_excel(result_b["full_pred_df"], result_b["metrics"], ".", "file_b")

    return (
        gr.update(value="✅ Pelatihan & evaluasi selesai untuk kedua file."),
        gr.update(value=metrics_md_a, visible=True),
        gr.update(value=cm_fig_a, visible=True),
        result_a["preview_df"],
        excel_path_a,
        gr.update(value=metrics_md_b, visible=True),
        gr.update(value=cm_fig_b, visible=True),
        result_b["preview_df"],
        excel_path_b,
    )


# -----------------------------
# Preprocessing ringan (khusus input manual)
# -----------------------------
def _light_stem(word: str) -> str:
    w = word
    for pre in (
        "meng", "meny", "men", "mem", "me",
        "peng", "peny", "pen", "pem",
        "ber", "ter", "per", "di", "ke", "se",
    ):
        if w.startswith(pre) and len(w) - len(pre) >= 3:
            if pre in ("meny", "peny"):
                w = "s" + w[len(pre):]
            else:
                w = w[len(pre):]
            break

    for suf in ("kan", "lah", "kah", "nya", "pun", "an", "i"):
        if w.endswith(suf) and len(w) - len(suf) >= 3:
            w = w[:-len(suf)]
            break

    return w


def preprocess_text(text: str) -> str:
    text = text.lower()
    text = re.sub(r"[^a-zA-Z\s]", " ", text)
    text = re.sub(r"\s+", " ", text).strip()
    tokens = [_light_stem(tok) for tok in text.split()]
    return " ".join(tokens)


def predict_single(text: str):
    if not text or not text.strip():
        return "Masukkan kalimat terlebih dahulu."
    if app_state["model"] is None or app_state["vectorizer"] is None:
        return "Model belum tersedia. Silakan upload dua file untuk melatih model terlebih dahulu."

    clean_text = preprocess_text(text)
    vec = app_state["vectorizer"].transform([clean_text])
    pred = app_state["model"].predict(vec)[0]
    return f"Prediksi: **{pred}**"


# -----------------------------
# UI
# -----------------------------
with gr.Blocks(css=".gr-markdown {font-size: 16px}") as app:
    gr.Markdown(
        """
    # 🛒 Analisis Sentimen Tokopedia/Shopee — Naive Bayes
    Upload dua file Excel/CSV yang berisikan kolom **content, score, sentiment** (sudah preprocessed).
    """
    )

    with gr.Row():
        with gr.Column():
            gr.Markdown("### Prediksi Kalimat Manual")
            inp_text = gr.Textbox(
                label="Masukkan kalimat",
                placeholder="contoh: aplikasi ini sangat membantu belanja saya",
            )
            btn_pred = gr.Button("Prediksi Sentimen")
            out_pred = gr.Markdown()
        with gr.Column():
            gr.Markdown("### Unggah 2 File & Jalankan Evaluasi")
            file_a = gr.File(
                label="File A (.xlsx/.xls/.csv): content, score, sentiment",
                file_types=[".xlsx", ".xls", ".csv"],
            )
            file_b = gr.File(
                label="File B (.xlsx/.xls/.csv): content, score, sentiment",
                file_types=[".xlsx", ".xls", ".csv"],
            )
            btn_run = gr.Button("Latih & Evaluasi")
            status = gr.Markdown()

    with gr.Row():
        with gr.Column():
            metrics_a = gr.Markdown(visible=False)
            cm_plot_a = gr.Plot(visible=False)
        with gr.Column():
            metrics_b = gr.Markdown(visible=False)
            cm_plot_b = gr.Plot(visible=False)

    with gr.Row():
        with gr.Column():
            gr.Markdown("### Preview Prediksi (5 Data dari Test Set) - File A")
            preview_tbl_a = gr.Dataframe(interactive=False)
            excel_dl_a = gr.File(
                label="Unduh Excel File A (hasil + metrics)",
                file_types=[".xlsx"],
                type="filepath",
                visible=True,
            )
        with gr.Column():
            gr.Markdown("### Preview Prediksi (5 Data dari Test Set) - File B")
            preview_tbl_b = gr.Dataframe(interactive=False)
            excel_dl_b = gr.File(
                label="Unduh Excel File B (hasil + metrics)",
                file_types=[".xlsx"],
                type="filepath",
                visible=True,
            )

    btn_run.click(
        handle_two_files,
        inputs=[file_a, file_b],
        outputs=[
            status,
            metrics_a,
            cm_plot_a,
            preview_tbl_a,
            excel_dl_a,
            metrics_b,
            cm_plot_b,
            preview_tbl_b,
            excel_dl_b,
        ],
    )

    btn_pred.click(predict_single, inputs=[inp_text], outputs=[out_pred])


if __name__ == "__main__":
    app.launch()
