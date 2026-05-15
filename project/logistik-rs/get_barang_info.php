<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "logistik");

// Periksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id_barang = $_GET['id_barang'];

// Query untuk mendapatkan info barang
$sql = "SELECT nama_barang, kategori FROM barang WHERE id_barang = '$id_barang'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode($row);
} else {
    echo json_encode(array("kategori" => "Tidak ditemukan"));
}

$conn->close();
?>
