<?php
session_start();
if (!isset($_SESSION["ses_username"]) || $_SESSION["ses_status"] != 'admin') {
    header("Location: login.php");
    exit();
}

// Koneksi database
$conn = new mysqli("localhost", "root", "", "logistik");

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil username dari parameter URL
if (isset($_GET['username'])) {
    $username = $_GET['username'];

    // Query untuk menghapus pengguna
    $sql = "DELETE FROM user WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);

    if ($stmt->execute()) {
        // Redirect ke halaman tambah_user.php setelah berhasil dihapus
        header("Location: tambah_user.php?message=User  deleted successfully");
    } else {
        echo "Error deleting user: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "No username provided.";
}

$conn->close();
?>