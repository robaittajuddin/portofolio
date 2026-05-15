<?php
session_start();

// Memeriksa apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost"; 
    $username = "root"; 
    $password = ""; 
    $dbname = "logistik"; 

    // Membuat koneksi ke database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Cek koneksi
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Ambil data dari form
    $id_barang = $_POST["id_barang"]; // ID barang yang diminta
    $jumlah = $_POST["jumlah"]; // Jumlah barang yang diminta
    $keterangan = $conn->real_escape_string($_POST["keterangan"]); // Keterangan tambahan
    $username = $_SESSION["ses_username"]; // Ambil username dari session

    // Buat ID permintaan yang unik
    $id_permintaan = "PB-" . str_pad(rand(1, 9999), 4, "0", STR_PAD_LEFT); // Menghasilkan ID permintaan dengan awalan PB-

    // Masukkan data permintaan barang ke tabel
    $sql = "INSERT INTO permintaan_barang (id_permintaan, id_barang, jumlah, username, status, keterangan) 
            VALUES ('$id_permintaan', '$id_barang', '$jumlah', '$username', 'menunggu', '$keterangan')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['status'] = 'success';
        $_SESSION['message'] = 'Permintaan barang berhasil dikirim dengan ID: ' . $id_permintaan;
    } else {
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'Error: ' . $sql . '<br>' . $conn->error;
    }

    // Menutup koneksi
    $conn->close();

    // Redirect ke halaman permintaan_barang.php
    header("Location: permintaan_barang.php");
    exit();
}
?>