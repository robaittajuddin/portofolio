<?php
session_start();

// Memeriksa apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost"; 
    $username = "root"; 
    $password = ""; 
    $dbname = "logistik"; 

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Cek koneksi
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Ambil data dari form
    $id_permintaan = $_POST["id_permintaan"]; // ID permintaan yang diterima
    $keterangan = $conn->real_escape_string($_POST["keterangan"]); // Keterangan diterima (jika ada)

    // Validasi ID permintaan agar aman digunakan dalam query
    if (is_numeric(substr($id_permintaan, 3))) { // Memastikan ID permintaan valid
        // Update status permintaan menjadi "Diterima" dan simpan keterangan
        $sql = "UPDATE permintaan_barang SET status = 'Diterima', keterangan_diterima = '$keterangan' WHERE id_permintaan = '$id_permintaan'";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['status'] = 'success';
            $_SESSION['message'] = 'Permintaan barang berhasil diterima dengan ID: ' . $id_permintaan;
        } else {
            $_SESSION['status'] = 'error';
            $_SESSION['message'] = 'Error: ' . $sql . '<br>' . $conn->error;
        }
    } else {
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'ID permintaan tidak valid.';
    }

    $conn->close();
    header("Location: kelola_permintaan.php");
    exit();
}