<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Edit Barang</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <h2>Edit Barang</h2>
    <?php
    // Periksa apakah ID barang diterima dari parameter URL
    if (isset($_GET['id_barang'])) {
        $id_barang = $_GET['id_barang'];

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

        // Lakukan query untuk mengambil data barang berdasarkan ID
        $query = "SELECT * FROM barang WHERE id_barang = '$id_barang'";
        $result = $conn->query($query);

        // Periksa apakah data barang ditemukan
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
    ?>
            <form action="proses_edit_barang.php" method="post">
                <input type="hidden" name="id_barang" value="<?php echo $row['id_barang']; ?>">
                <label for="nama_barang">Nama Barang:</label>
                <input type="text" id="nama_barang" name="nama_barang" value="<?php echo $row['nama_barang']; ?>"><br><br>
                <label for="kategori">Kategori:</label>
                <input type="text" id="kategori" name="kategori" value="<?php echo $row['kategori']; ?>"><br><br>
                <label for="stok">Stok:</label>
                <input type="number" id="stok" name="stok" value="<?php echo $row['stok']; ?>"><br><br>
                <input type="submit" value="Simpan Perubahan">
            </form>
    <?php
        } else {
            echo "Data barang tidak ditemukan.";
        }

        // Tutup koneksi
        $conn->close();
    } else {
        echo "ID Barang tidak ditemukan.";
    }
    ?>
</body>

</html>
