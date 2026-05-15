<?php
session_start();
if (!isset($_SESSION["ses_username"]) || $_SESSION["ses_status"] != 'admin') {
    header("Location: login.php");
    exit();
}


// If the user is logged in, retrieve their username and role
$username = $_SESSION["ses_username"];
$role = $_SESSION["ses_status"];
?>


<!DOCTYPE html>
<htmlhtml lang="en">

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
        <link
            href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap"
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
        <!-- <link rel="stylesheet" href="sweetalert2/sweetalert2.css"> -->
        <link href="css/style.css" rel="stylesheet">
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.min.css'>

        <!-- print -->
    </head>

    <body>

        <div class="container-fluid position-relative d-flex p-0">
            <!-- Spinner Start -->
            <div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
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
                        <a href="index.php" class="nav-item nav-link"><i
                        <?php if ($role == 'admin'): ?>
                        class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                        <a href="barang.php" class="nav-item nav-link active"><i class="fa fa-table me-2"></i>Barang</a>
                        <a href="barang_masuk.php" class="nav-item nav-link"><i class="fa fa-th me-2"></i>Barang Masuk</a>
                        <a href="barang_keluar.php" class="nav-item nav-link"><i class="fa fa-th me-2"></i>Barang Keluar</a>
                        <a href="kelola_permintaan.php" class="nav-item nav-link"><i class="fa fa-th me-2"></i>Kelola Permintaan</a>
                        <a href="permintaan_barang.php" class="nav-item nav-link"><i class="fa fa-th me-2"></i>Permintaan Barang</a>
                        <a href="status_permintaan.php" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Status Permintaan</a>
                        <a href="laporan.php" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Laporan</a>  
                        <a href="tambah_user.php" class="nav-item nav-link"><i class="fa fa-user-plus me-2"></i>Tambah User</a>                        <?php elseif ($role == 'user'): ?>
                        <?php endif; ?>
                    </div>
                </nav>
            </div>
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
                <!-- Blank Start -->
                <div class="container mt-5">
                </div>

                <!-- Tampilan Daftar Barang -->
                <div class="container">
                    <h2 class="mb-4">Daftar Barang</h2>
                    <button type="button" class="btn btn-danger btn-sm float-end" data-bs-toggle="modal" data-bs-target="#tambahBarang">Tambah Barang</button>
                    <?php
                    $search = isset($_GET['search']) ? $_GET['search'] : '';
                    ?>

                    <!-- Form Pencarian Barang-->
                    <form method="GET" action="" class="mb-4">
                        <div class="input-group" style="max-width: 300px;">
                            <input type="text" name="search" class="form-control py-2 border-primary" style="outline: 2px;" placeholder="Cari Barang..." value="<?= htmlspecialchars($search); ?>">
                            <button type="submit" class="btn btn-primary px-4 py-2">Cari</button>
                        </div>
                    </form>

                    <!-- Tabel Daftar Barang -->
                    <table class="table table-dark" id="barangTable">
                        <thead>
                            <tr>
                                <th scope="col">ID Barang</th>
                                <th scope="col">Nama Barang</th>
                                <th scope="col">Kategori</th>
                                <th scope="col">Stok</th>
                                <th scope="col">Last Entry</th>
                                <th scope="col">Last Out</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="daftarBarang">
                            <?php include 'tampilkan_barang.php'; ?>
                        </tbody>
                    </table>
                </div>

                    
                    <!-- Tambah Barang -->
                <div class="modal fade" id="tambahBarang" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="background-color:rgb(77, 55, 58); color: #ffffff;">
                            <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title" id="exampleModalLabel">Tambah Barang</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="tambahBarang" action="tambah_barang.php" method="post">
                                    <div class="mb-3">
                                        <label for="namaBarang" class="form-label">Nama Barang</label>
                                        <input type="text" class="form-control" id="namaBarang" name="namaBarang"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="kategori" class="form-label">Kategori</label>
                                        <select class="form-select" id="kategori" name="kategori" required>
                                            <option value="">Pilih Kategori</option>
                                            <option value="Medis">Medis</option>
                                            <option value="Non-Medis">Non-Medis</option>
                                            <option value="ATK">ATK</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-danger">Tambah</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Footer Start -->
                <div class="container-fluid pt-4 px-4">
                    <div class="bg-secondary rounded-top p-4">
                        <div class="row">
                            <div class="col-12 col-sm-6 text-center text-sm-start">
                                &copy; <a href="#">RS NUSRUSSYIFA</a>, All Right Reserved.
                            </div>
                            <div class="col-12 col-sm-6 text-center text-sm-end">
                                <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
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
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.all.min.js"></script>



            <!-- Template Javascript -->
            <script src="js/main.js"></script>
            <?php
            if (isset($_SESSION['status']) && $_SESSION['status'] == 'success') {
                echo "
                    <script>
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: '" . $_SESSION['message'] . "',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    </script>";
                                unset($_SESSION['status']);
                                unset($_SESSION['message']);
                            } elseif (isset($_SESSION['status']) && $_SESSION['status'] == 'error') {
                                echo "
                    <script>
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: '" . $_SESSION['message'] . "',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    </script>";
                                unset($_SESSION['status']);
                                unset($_SESSION['message']);
                            }
                            ?>
            <script src="sweetalert2/sweetalert2.js"></script>
    </body>

    </html>