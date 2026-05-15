<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "logistik";
$items_per_page = 10; // Jumlah data per halaman

// Inisialisasi variabel $search, pastikan selalu ada
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Hitung jumlah total data (dengan pencarian)
$total_sql = "SELECT COUNT(*) FROM barang WHERE nama_barang LIKE '%$search%'";
$total_result = $conn->query($total_sql);
$total_row = $total_result->fetch_row();
$total_items = $total_row[0];

// Tentukan halaman saat ini
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $items_per_page;

// Jalankan query untuk mengambil data barang dengan paginasi dan pencarian
$query = "SELECT * FROM barang WHERE nama_barang LIKE '%$search%' ORDER BY nama_barang ASC LIMIT $offset, $items_per_page";
$result = $conn->query($query);

// Jika data ditemukan, tampilkan dalam format tabel
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id_barang"] . "</td>";
        echo "<td>" . $row["nama_barang"] . "</td>";
        echo "<td>" . $row["kategori"] . "</td>";
        echo "<td id='stok_" . $row["id_barang"] . "'>" . $row["stok"] . "</td>";
        // Format waktu untuk 'terakhir_masuk'
        $terakhir_masuk = $row["terakhir_masuk"] ? (new DateTime($row["terakhir_masuk"]))->format('d.M.Y - H:i:s') : '-';
        echo "<td>" . $terakhir_masuk . "</td>";

        // Format waktu untuk 'terakhir_keluar'
        $terakhir_keluar = $row["terakhir_keluar"] ? (new DateTime($row["terakhir_keluar"]))->format('d.M.Y - H:i:s') : '-';
        echo "<td>" . $terakhir_keluar . "</td>";
        echo "<td><a href='hapus_barang.php?id_barang=" . $row["id_barang"] . "'>Hapus</a></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='7'>Tidak ada data barang.</td></tr>";
}

// Tutup koneksi
$conn->close();
?>

<!-- Link Pagination -->
<?php
$total_pages = ceil($total_items / $items_per_page);

echo "<nav aria-label='Page navigation example'>";
echo "<ul class='pagination'>";
// Previous button
if ($page > 1) {
    echo "<li class='page-item'><a class='page-link' href='?page=" . ($page - 1) . "&search=" . urlencode($search) . "'>Previous</a></li>";
}
// Page numbers
for ($i = 1; $i <= $total_pages; $i++) {
    if ($i == $page) {
        echo "<li class='page-item active'><a class='page-link' href='?page=$i&search=" . urlencode($search) . "'>$i</a></li>";
    } else {
        echo "<li class='page-item'><a class='page-link' href='?page=$i&search=" . urlencode($search) . "'>$i</a></li>";
    }
}
// Next button
if ($page < $total_pages) {
    echo "<li class='page-item'><a class='page-link' href='?page=" . ($page + 1) . "&search=" . urlencode($search) . "'>Next</a></li>";
}
echo "</ul>";
echo "</nav>";
?>
