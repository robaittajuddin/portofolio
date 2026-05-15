<?php
// Pastikan form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lakukan koneksi ke database (ganti sesuai dengan informasi koneksi Anda)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "logistik";
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Periksa koneksi
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Mendapatkan data dari form
    $id_barang = $_POST["id_barang"];
    $kategori = $_POST["kategori"];
    $jumlah = $_POST["jumlah"];

    // Lakukan query untuk memeriksa apakah data barang sudah ada sebelumnya di tabel barang_masuk
    $sql_cek_barang_masuk = "SELECT * FROM barang_masuk WHERE id_barang = '$id_barang' AND kategori = '$kategori'";
    $result_barang_masuk = $conn->query($sql_cek_barang_masuk);

    if ($result_barang_masuk->num_rows > 0) {
        // Jika data barang sudah ada di barang_masuk, update jumlahnya
        $row_barang_masuk = $result_barang_masuk->fetch_assoc();
        $jumlah_sebelumnya = $row_barang_masuk["jumlah"];
        $jumlah_baru = $jumlah_sebelumnya + $jumlah;

        // Lakukan query untuk update jumlah barang masuk
        $sql_update_barang_masuk = "UPDATE barang_masuk SET jumlah = $jumlah_baru, terakhir_masuk = NOW() WHERE id_barang = '$id_barang' AND kategori = '$kategori'";

        if ($conn->query($sql_update_barang_masuk) === FALSE) {
            echo "Error updating barang masuk: " . $conn->error;
        } else {
            // Update jumlah stok barang dan tanggal terakhir masuk di tabel barang
            $sql_update_stok = "UPDATE barang SET stok = stok + $jumlah, terakhir_masuk = NOW() WHERE id_barang = '$id_barang'";

            if ($conn->query($sql_update_stok) === FALSE) {
                echo "Error updating stock: " . $conn->error;
            } else {
                echo "Barang masuk berhasil diupdate.";
                header("Location: barang.php"); // Ganti dengan halaman sebelumnya yang sesuai
                exit();
            }
        }
    } else {
        // Jika data barang belum ada di barang_masuk, tambahkan data baru
        // Generate id_bm yang unik dengan awalan 'bm' dan panjang 1-4 karakter
        $random_length = rand(1, 4); // Panjang acak antara 1 dan 4
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz'; // Kombinasi huruf dan angka
        $random_string = substr(str_shuffle(str_repeat($characters, 4)), 0, $random_length); // Menghasilkan string acak
        $id_bm = 'bm-' . $random_string;

        $sql_masuk = "INSERT INTO barang_masuk (id_bm, id_barang, kategori, jumlah, terakhir_masuk) VALUES ('$id_bm', '$id_barang', '$kategori', '$jumlah', NOW())";

        // Jalankan query untuk memasukkan data ke dalam tabel barang_masuk
        if ($conn->query($sql_masuk) === TRUE) {
            // Update jumlah stok barang dan tanggal terakhir masuk di tabel barang
            $sql_update_stok = "UPDATE barang SET stok = stok + $jumlah, terakhir_masuk = NOW() WHERE id_barang = '$id_barang'";

            if ($conn->query($sql_update_stok) === FALSE) {
                echo "Error updating stock: " . $conn->error;
            } else {
                echo "Barang masuk berhasil diproses.";
                header("Location: barang.php"); // Ganti dengan halaman sebelumnya yang sesuai
                exit();
            }
        } else {
            echo "Error inserting barang masuk: " . $conn->error;
        }
    }

    // Tutup koneksi
    $conn->close();
} else {
    echo "Error: Metode tidak diperbolehkan.";
}
?>