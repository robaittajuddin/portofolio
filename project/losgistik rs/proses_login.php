<?php
session_start();

// Database credentials
$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "logistik";

// Create connection
$conn = new mysqli($servername, $username_db, $password_db, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['btnLogin'])) {
    // Ambil input dari form
    $username = $_POST['txUsername'];
    $email = $_POST['txEmail'];
    $password = $_POST['txPassword'];

    // Validasi input
    if (empty($username) || empty($email) || empty($password)) {
        echo "Please fill in all fields.";
        exit();
    }

    // Query untuk memeriksa kredensial pengguna
    $query = "SELECT * FROM user WHERE username = ? AND email = ? AND password = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $username, $email, $password); // Binding parameter
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role']; // Mengasumsikan 'role' adalah kolom di tabel 'user'
        
        // Redirect berdasarkan peran
        if ($user['role'] == 'admin') {
            header("Location: index.php"); // Redirect ke dashboard admin
        } else {
            header("Location: permintaan_barang.php"); // Redirect ke halaman pengguna
        }
        exit(); // Pastikan tidak ada output lain yang dikirim sebelum pengalihan
    } else {
        echo "Invalid username, email, or password";
    }
}
?>