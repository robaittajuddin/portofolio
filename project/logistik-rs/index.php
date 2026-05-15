<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["ses_username"])) {
    // If not, redirect to the login page
    echo "<meta http-equiv='refresh' content='0; url=login.php'>";
    exit();
}
// If the user is logged in, retrieve their username and role
$username = $_SESSION["ses_username"];
$role = $_SESSION["ses_status"];

$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "logistik";
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Retrieve counts from database
$sql_total_barang = "SELECT COUNT(*) AS total_barang FROM barang";
$sql_total_masuk = "SELECT SUM(jumlah) AS total_masuk FROM barang_masuk";
$sql_total_keluar = "SELECT SUM(jumlah) AS total_keluar FROM barang_keluar";

$result_total_barang = $conn->query($sql_total_barang);
$result_total_masuk = $conn->query($sql_total_masuk);
$result_total_keluar = $conn->query($sql_total_keluar);

$total_barang = $result_total_barang->fetch_assoc()['total_barang'];
$total_masuk = $result_total_masuk->fetch_assoc()['total_masuk'];
$total_keluar = $result_total_keluar->fetch_assoc()['total_keluar'];

$conn->close();
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

    <style>
        .moving-text {
            white-space: nowrap;
            overflow: hidden;
            animation: moveText 10s linear infinite;
        }

        @keyframes moveText {
            0% {
                transform: translateX(100%);
            }

            100% {
                transform: translateX(-100%);
            }
        }
    </style>



</head>

<body>

    <div class="container-fluid position-relative d-flex p-0">
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

                <div class="navbar-nav w-100">
    <!-- Menu Index untuk Semua Pengguna -->
    <a href="index.php" class="nav-item nav-link active"><i class="fa fa-home me-2"></i>Dashboard</a>

    <!-- Role-based Navigation -->
    <?php if ($role == 'admin'): ?>
        <a href="barang.php" class="nav-item nav-link"><i class="fa fa-store me-2"></i>Barang</a>
        <a href="barang_masuk.php" class="nav-item nav-link"><i class="fa fa-th me-2"></i>Barang Masuk</a>
        <a href="barang_keluar.php" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Barang Keluar</a>
        <a href="kelola_permintaan.php" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Kelola Permintaan</a>
        <a href="permintaan_barang.php" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Permintaan Barang</a>
        <a href="status_permintaan.php" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Status Permintaan</a>
        <a href="laporan.php" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Laporan</a>            
        <a href="tambah_user.php" class="nav-item nav-link"><i class="fa fa-user-plus me-2"></i>Tambah User</a>
    <?php elseif ($role == 'user'): ?>
        <a href="permintaan_barang.php" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Permintaan Barang</a>
        <a href="laporan.php" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Status Permintaan</a>
    <?php endif; ?>
</div>

            </nav>
        </div>
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">
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

            <!-- Dashboard Content Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="text-center mb-4">
                    <h1 class="display-5 mb-4">Selamat Datang di Logistik Barang</h1>
                    <h1 class="display-5 mb-4">Rumah Sakit Umum Nurussyifa</h1>
                </div>
                <div class="d-flex flex-column align-items-center">
                    <div class="bg-primary rounded text-white d-flex align-items-center justify-content-between p-4 mb-3" style="width: 60%;">
                        <i class="fa fa-cubes fa-3x mb-2"></i>
                        <div class="ms-3">
                            <p class="mb-2">Total Barang</p>
                            <h6 class="mb-0" style="font-size: 25px;"><?php echo $total_barang; ?></h6>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between w-100">
                        <div class="bg-danger rounded text-white d-flex align-items-center justify-content-between p-4 flex-grow-1 me-3">
                            <i class="fa fa-arrow-down fa-3x"></i>
                            <div class="ms-3">
                                <p class="mb-2">Barang Keluar</p>
                                <h6 class="mb-0" style="font-size: 25px;"><?php echo $total_keluar; ?></h6>
                            </div>
                        </div>
                        <div class="bg-success rounded text-white d-flex align-items-center justify-content-between p-4 flex-grow-1 ms-3">
                            <i class="fa fa-arrow-up fa-3x"></i>
                            <div class="ms-3">
                                <p class="mb-2">Barang Masuk</p>
                                <h6 class="mb-0" style="font-size: 25px;"><?php echo $total_masuk; ?></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Dashboard Content End -->

            <!-- Footer Start -->
            <div class="container-fluid pt-4 px-3">
                <div class="bg-secondary rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                            &copy; <a href="#">RS NUSRUSSYIFA</a>, All Right Reserved.
                        </div>
                        <div class="col-12 col-sm-6 text-center text-sm-end">
                            <!-- (Footer credit remains unchanged) -->
                            Designed By <a href="#">Team IT</a>
                            <br>Distributed By: <a href="https://themewagon.com" target="_blank">ThemeWagon</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End -->
        </div>
        <!-- Content End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>