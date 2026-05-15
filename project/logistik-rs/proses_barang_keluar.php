<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "logistik";
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    $id_barang = $_POST["id_barang"];
    $kategori = $_POST["kategori"];
    $jumlah = $_POST["jumlah"];

    // Memeriksa apakah data barang sudah ada sebelumnya
    $sql_cek_barang = "SELECT * FROM barang WHERE id_barang = '$id_barang'";
    $result = $conn->query($sql_cek_barang);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $jumlah_sebelumnya = $row["stok"];

        if ($jumlah >= 0 && $jumlah <= $jumlah_sebelumnya) {
            $jumlah_baru = $jumlah_sebelumnya - $jumlah;

            $conn->begin_transaction();

            try {
                $sql_update_stok = "UPDATE barang SET stok = $jumlah_baru, terakhir_keluar = NOW() WHERE id_barang = '$id_barang'";
                if ($conn->query($sql_update_stok) === FALSE) {
                    throw new Exception("Error updating stock: " . $conn->error);
                }

                $sql_cek_barang_keluar = "SELECT * FROM barang_keluar WHERE id_barang = '$id_barang' AND kategori = '$kategori'";
                $result_barang_keluar = $conn->query($sql_cek_barang_keluar);

                if ($result_barang_keluar->num_rows > 0) {
                    $row_barang_keluar = $result_barang_keluar->fetch_assoc();
                    $jumlah_keluar_sebelumnya = $row_barang_keluar["jumlah"];
                    $jumlah_keluar_baru = $jumlah_keluar_sebelumnya + $jumlah;

                    $sql_update_barang_keluar = "UPDATE barang_keluar SET jumlah = $jumlah_keluar_baru, terakhir_keluar = NOW() WHERE id_barang = '$id_barang' AND kategori = '$kategori'";
                    if ($conn->query($sql_update_barang_keluar) === FALSE) {
                        throw new Exception("Error updating barang keluar: " . $conn->error);
                    }
                } else {

                    $random_length = rand(1, 4); // Panjang acak antara 1 dan 4
                    $characters = '0123456789abcdefghijklmnopqrstuvwxyz'; // Kombinasi huruf dan angka
                    $random_string = substr(str_shuffle(str_repeat($characters, 4)), 0, $random_length); // Menghasilkan string acak
                    $id_bk = 'bk-' . $random_string;

                    $sql_insert_barang_keluar = "INSERT INTO barang_keluar (id_bk, id_barang, kategori, jumlah, terakhir_keluar) VALUES ('$id_bk','$id_barang', '$kategori', '$jumlah', NOW())";
                    if ($conn->query($sql_insert_barang_keluar) === FALSE) {
                        throw new Exception("Error inserting barang keluar: " . $conn->error);
                    }
                }

                $conn->commit();

                echo "<script>
                    alert('Barang keluar berhasil diproses.');
                    window.location.href = 'barang.php';
                </script>";
                exit();
            } catch (Exception $e) {
                $conn->rollback();
                echo "<script>
                    alert('Kesalahan: " . addslashes($e->getMessage()) . "');
                    window.history.back();
                </script>";
                exit();
            }
        } else {
            echo "<script>
                alert('Jumlah barang keluar tidak boleh melebihi stok saat ini.');
                window.history.back();
            </script>";
            exit();
        }
    } else {
        echo "<script>
            alert('Barang tidak ditemukan.');
            window.history.back();
        </script>";
        exit();
    }

} else {
    echo "<script>
        alert('Metode tidak diperbolehkan.');
        window.history.back();
    </script>";
    exit();
}
?>
