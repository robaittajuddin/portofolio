<?php
// Header untuk mencegah caching
header("Cache-Control: no-cache, no-store, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: 0"); // Cegah cache di browser

// Koneksi ke database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'logistik';

$conn = new mysqli($host, $username, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Pastikan membaca data terbaru
$conn->query("SET SESSION TRANSACTION ISOLATION LEVEL READ COMMITTED");

// Ambil data dari form
$kategori = $_POST['kategori'] ?? 'all'; // Default ke 'all'
$start_date = $_POST['start_date'] ?? date('Y-m-d'); // Default ke tanggal saat ini
$end_date = $_POST['end_date'] ?? date('Y-m-d'); // Default ke tanggal saat ini
$tipe_laporan = $_POST['tipe_laporan'] ?? 'barang'; // Default ke 'barang'

// Query berdasarkan pilihan
$query = "";
if ($tipe_laporan == 'barang') {
    if ($kategori == 'all') {
        $query = "SELECT id_barang, nama_barang, kategori, stok, terakhir_masuk, terakhir_keluar 
                  FROM barang 
                  WHERE (terakhir_masuk >= '$start_date' AND terakhir_masuk <= '$end_date 23:59:59' 
                  OR terakhir_keluar >= '$start_date' AND terakhir_keluar <= '$end_date 23:59:59')";
    } else {
        $query = "SELECT id_barang, nama_barang, kategori, stok, terakhir_masuk, terakhir_keluar 
                  FROM barang 
                  WHERE kategori = '$kategori' 
                  AND (terakhir_masuk >= '$start_date' AND terakhir_masuk <= '$end_date 23:59:59' 
                  OR terakhir_keluar >= '$start_date' AND terakhir_keluar <= '$end_date 23:59:59')";
    }
} else {
    if ($kategori == 'all') {
        $query = "SELECT pb.id_permintaan, b.nama_barang, pb.jumlah, pb.status, pb.keterangan_penolakan, pb.tanggal_permintaan, pb.username 
                  FROM permintaan_barang pb 
                  JOIN barang b ON pb.id_barang = b.id_barang 
                  WHERE pb.tanggal_permintaan >= '$start_date' AND pb.tanggal_permintaan <= '$end_date 23:59:59'";
    } else {
        $query = "SELECT pb.id_permintaan, b.nama_barang, pb.jumlah, pb.status, pb.keterangan_penolakan, pb.tanggal_permintaan, pb.username 
                  FROM permintaan_barang pb 
                  JOIN barang b ON pb.id_barang = b.id_barang 
                  WHERE b.kategori = '$kategori' 
                  AND pb.tanggal_permintaan >= '$start_date' AND pb.tanggal_permintaan <= '$end_date 23:59:59'";
    }
}

// Jalankan query
$result = $conn->query($query);

// Cek apakah query berhasil
if (!$result) {
    die("Query gagal: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 24px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .footer {
            text-align: right;
            margin-top: 50px;
        }
        .footer p {
            margin: 5px 0;
        }
        .print-btn {
            margin-top: 20px;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            display: inline-block;
        }
        @media print {
            .print-btn {
                display: none;
            }
        }
    </style>
</head>
<body>

<h2>Laporan <?php echo htmlspecialchars(ucfirst($tipe_laporan)); ?></h2>

<table>
    <thead>
        <tr>
            <th>No.</th>
            <?php if ($tipe_laporan == 'barang'): ?>
                <th>ID Barang</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Stok</th>
                <th>Terakhir Masuk</th>
                <th>Terakhir Keluar</th>
            <?php else: ?>
                <th>ID Permintaan</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Status</th>
                <th>Keterangan Penolakan</th>
                <th>Tanggal Permintaan</th>
                <th>Username</th>
            <?php endif; ?>
        </tr>
    </thead>
    <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php $no = 1; ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <?php foreach ($row as $key => $column): ?>
                        <td>
                            <?php 
                            // Format tanggal hanya untuk kolom tertentu
                            if (in_array($key, ['terakhir_masuk', 'terakhir_keluar', 'tanggal_permintaan'])) {
                                echo date('d F Y', strtotime($column)); // Format tanggal
                            } else {
                                echo htmlspecialchars($column); // Kolom lainnya tetap
                            }
                            ?>
                        </td>
                    <?php endforeach; ?>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="7">Tidak ada data yang ditemukan</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<div class="footer">
    <p>Kudus, <?php echo date('d F Y'); ?></p><br><br><br>
    <p>________________</p>
</div>

<button class="print-btn" onclick="window.print()">Cetak Laporan</button>

</body>
</html>
