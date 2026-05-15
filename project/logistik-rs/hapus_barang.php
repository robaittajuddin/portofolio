<?php
// Periksa apakah ID barang diterima
if (isset($_GET['id_barang'])) {
    $idBarang = $_GET['id_barang'];

    // Lakukan koneksi ke database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "logistik";

    // Buat koneksi
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Periksa koneksi
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Buat query hapus untuk tabel permintaan_barang terlebih dahulu
    $sql_delete_permintaan = "DELETE FROM permintaan_barang WHERE id_barang = '$idBarang'";

    // Eksekusi query hapus untuk tabel permintaan_barang
    if ($conn->query($sql_delete_permintaan) === TRUE) {
        // Setelah menghapus entri terkait di tabel permintaan_barang, lanjutkan dengan menghapus entri di tabel barang masuk
        $sql_delete_masuk = "DELETE FROM barang_masuk WHERE id_barang = '$idBarang'";

        // Eksekusi query hapus untuk tabel barang masuk
        if ($conn->query($sql_delete_masuk) === TRUE) {
            // Setelah menghapus entri terkait di tabel barang masuk, lanjutkan dengan menghapus entri di tabel barang keluar
            $sql_delete_keluar = "DELETE FROM barang_keluar WHERE id_barang = '$idBarang'";

            // Eksekusi query hapus untuk tabel barang keluar
            if ($conn->query($sql_delete_keluar) === TRUE) {
                // Lanjutkan dengan menghapus barang dari tabel barang
                $sql_delete_barang = "DELETE FROM barang WHERE id_barang = '$idBarang'";

                // Eksekusi query hapus untuk tabel barang
                if ($conn->query($sql_delete_barang) === TRUE) {
                    echo "Record deleted successfully";
                } else {
                    echo "Error deleting record in barang table: " . $conn->error;
                }
            } else {
                echo "Error deleting record in barang_keluar table: " . $conn->error;
            }
        } else {
            echo "Error deleting record in barang_masuk table: " . $conn->error;
        }
    } else {
        echo "Error deleting record in permintaan_barang table: " . $conn->error;
    }

    // Tutup koneksi
    $conn->close();

    // Arahkan kembali ke halaman daftar barang
    header('Location: barang.php'); // Sesuaikan dengan nama halaman daftar barang Anda
} else {
    echo "Error: ID Barang tidak ditemukan.";
}
?>
