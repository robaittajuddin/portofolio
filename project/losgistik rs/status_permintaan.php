<?php
session_start();
if (!isset($_SESSION["ses_username"]) || ($_SESSION["ses_status"] == 'user' && $_SESSION["ses_status"] != 'user')) {
    header("Location: login.php");
    exit();
}


// If the user is logged in, retrieve their username and role
$username = $_SESSION["ses_username"];
$role = $_SESSION["ses_status"];
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Logistik</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <script src="sweetalert2/sweetalert2.css"></script>

    <!-- sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="d-flex flex-column min-vh-100">
    <div class="container-fluid position-relative d-flex p-0 flex-grow-1">
        <!-- Spinner Start -->
        <div id="spinner"
            class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-secondary navbar-dark">
                <a href="index.php" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"><i class="fa fa-user-edit me-2"></i>Logistik</h3>
                </a>
                <div class="navbar-nav w-100">
                <div class="d-flex align-items-center ms-4 mb-4">
                <div class="d-flex align-items-center ms-3">
                        <!-- Icon Avatar -->
                        <i class="bi bi-person-circle me-2" style="font-size: 2.5rem; color: #fff;"></i>
                        <div>
                            <h6 class="mb-0" data-bs-toggle="collapse" href="#logoutAccordion" role="button" aria-expanded="false" aria-controls="logoutAccordion">
                                <?php echo $_SESSION["ses_username"]; ?>
                            </h6>
                            <!-- Dropdown -->
                            <div class="collapse" id="logoutAccordion">
                                <a href="logout.php" class="btn btn-danger btn-sm mt-2">Logout</a>
                            </div>
                        </div>
                    </div>
            </div>
                <?php if ($role == 'admin'): ?>
                    <a href="index.php" class="nav-item nav-link"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                    <a href="barang.php" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Barang</a>
                    <a href="barang_masuk.php" class="nav-item nav-link"><i class="fa fa-th me-2"></i>Barang Masuk</a>
                    <a href="barang_keluar.php" class="nav-item nav-link"><i class="fa fa-th me-2"></i>Barang Keluar</a>
                    <a href="kelola_permintaan.php" class="nav-item nav-link"><i class="fa fa-th me-2"></i>Kelola Permintaan</a>
                    <a href="permintaan_barang.php" class="nav-item nav-link"><i class="fa fa-th me-2"></i>Permintaan Barang</a>
                    <a href="status_permintaan.php" class="nav-item nav-link active"><i class="fa fa-table me-2"></i>Status Permintaan</a> 
                    <a href="laporan.php" class="nav-item nav-link"><i class="fa fa-table me-2"></i>laporan</a>         
                    <a href="tambah_user.php" class="nav-item nav-link"><i class="fa fa-user-plus me-2"></i>Tambah User</a>           
                <?php elseif ($role == 'user'): ?>
                        <a href="index.php" class="nav-item nav-link"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                        <a href="permintaan_barang.php" class="nav-item nav-link"><i class="fa fa-th me-2"></i>Permintaan Barang</a>
                        <a href="status_permintaan.php" class="nav-item nav-link active"><i class="fa fa-table me-2"></i>Status Permintaan</a>                    
                <?php endif; ?>
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->

        <!-- Content Start -->
        <div class="content flex-grow-1">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-10">
                <a href="index.php" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-user-edit"></i></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
            </nav>
            <!-- Navbar End -->

            <!-- Form Permintaan Barang Start -->
            <?php
            // Koneksi ke database
            $conn = new mysqli("localhost", "root", "", "logistik");

            // Cek koneksi
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Query untuk mendapatkan semua permintaan oleh pengguna termasuk username dan departemen
            $sql = "SELECT p.id_permintaan, b.nama_barang, p.keterangan, p.jumlah, p.status, p.tanggal_permintaan, u.username, u.departemen, p.keterangan_diterima, p.keterangan_penolakan
                    FROM permintaan_barang p 
                    JOIN barang b ON p.id_barang = b.id_barang 
                    JOIN user u ON p.username = u.username 
                    WHERE p.status != 'menunggu konfirmasi'
                    ORDER BY p.tanggal_permintaan DESC";
            $result = $conn->query($sql);
            ?>

            <div class="container">
                <h2 class="my-4 text-center">Status Permintaan Barang</h2>
                <table class="table table-bordered" id="statusTable">
                    <thead>
                        <tr>
                            <th>ID Permintaan</th>
                            <th>Username</th>
                            <th>Departemen</th>
                            <th>Barang</th>
                            <th>Keterangan</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Tanggal Permintaan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['id_permintaan'] . "</td>";
                                echo "<td>" . $row['username'] . "</td>";
                                echo "<td>" . $row['departemen'] . "</td>";
                                echo "<td>" . $row['nama_barang'] . "</td>";
                                echo "<td>" . $row['keterangan'] . "</td>";
                                echo "<td>" . $row['jumlah'] . "</td>";
                                // Menampilkan status dan keterangan penolakan
                                if ($row['status'] == 'Diterima') {
                                    echo "<td>Diterima - " . htmlspecialchars($row['keterangan_diterima']) . "</td>";
                                } elseif ($row['status'] == 'Ditolak') {
                                    echo "<td>Ditolak - " . htmlspecialchars($row['keterangan_penolakan']) . "</td>";
                                } else {
                                    echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                                }
                                $tanggal_permintaan = $row['tanggal_permintaan'];
                                $formatted_date = date('d.M.Y - H:i', strtotime($tanggal_permintaan));
                                echo "<td>" . htmlspecialchars($formatted_date) . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>Belum ada permintaan yang diproses.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <?php $conn->close(); ?>

            <!-- Footer Start -->
            <div class="container-fluid pt-4 px-4 mt-auto">
                <div class="bg-secondary rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                            &copy; <a href="#">RS NUSRUSSYIFA</a>, All Right Reserved.
                        </div>
                        <div class="col-12 col-sm-6 text-center text-sm-end">
                            Designed By <a href="https://htmlcodex.com">HTML Codex</a>
                            <br>Distributed By: <a href="https://themewagon.com" target="_blank">ThemeWagon</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End -->

            <!-- Back to Top -->
            <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
        </div>
        <!-- Content End -->

    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    <script src="sweetalert2/sweetalert2.js"></script>

</body>

</html>