<?php
$conn = new mysqli("localhost", "root", "", "logistik");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id_permintaan = $_POST['id_permintaan'];

// Query untuk mendapatkan status permintaan
$sql = "SELECT status FROM permintaan_barang WHERE id_permintaan = '$id_permintaan'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode(['status' => $row['status']]);
} else {
    echo json_encode(['status' => 'menunggu']);
}

$conn->close();
?>
