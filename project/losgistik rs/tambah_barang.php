<?php
session_start();

// Memeriksa apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost"; 
    $username = "root"; 
    $password = ""; 
    $dbname = "logistik"; 

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    $namaBarang = $_POST["namaBarang"];
    $kategori = $_POST["kategori"];

    $idBarang = "";
    switch ($kategori) {
        case "Medis":
            $idBarang = "MD-";  // Prefix untuk barang medis
            break;
        case "Non-Medis":
            $idBarang = "NM-";  // Prefix untuk barang non-medis
            break;
        case "ATK":
            $idBarang = "ATK-"; // Prefix untuk barang ATK
            break;
        default:
            $idBarang = "UNK-"; // Default jika kategori tidak ditemukan
            break;
    }

    // Menambahkan nomor urut barang (contoh: MD-001, NM-002, ATK-003, dll.)
    $idBarang .= str_pad(rand(1, 999), 3, "0", STR_PAD_LEFT); // Menghasilkan nomor acak

    $sql = "INSERT INTO barang (id_barang, nama_barang, kategori, stok) 
            VALUES ('$idBarang', '$namaBarang', '$kategori', 0)";

    if ($conn->query($sql) === TRUE) {
        $conn->close();
        $_SESSION['status'] = 'success';
        $_SESSION['message'] = 'Barang berhasil ditambahkan dengan kode: ' . $idBarang;
    } else {
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'Error: ' . $sql . '<br>' . $conn->error;
    }

    header("Location: barang.php");
    exit();
}
?>
