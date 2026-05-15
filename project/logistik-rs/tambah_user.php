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
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet"> 
    
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
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.min.css'>

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
                        <a href="barang.php" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Barang</a>
                        <a href="barang_masuk.php" class="nav-item nav-link "><i class="fa fa-th me-2"></i>Barang Masuk</a>
                        <a href="barang_keluar.php" class="nav-item nav-link"><i class="fa fa-th me-2"></i>Barang Keluar</a>
                        <a href="kelola_permintaan.php" class="nav-item nav-link"><i class="fa fa-th me-2"></i>Kelola Permintaan</a>
                        <a href="permintaan_barang.php" class="nav-item nav-link"><i class="fa fa-th me-2"></i>Permintaan Barang</a>
                        <a href="status_permintaan.php" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Status Permintaan</a>
                        <a href="laporan.php" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Laporan</a>   
                        <a href="tambah_user.php" class="nav-item nav-link active"><i class="fa fa-user-plus me-2"></i>Tambah User</a>                        <?php elseif ($role == 'user'): ?>
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

              <!-- Blank Start -->
              <div class="container">
                    <h2>Daftar Pengguna</h2>
                    <!-- Tabel Daftar Pengguna -->
                    <table class="table responsive">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Departemen</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                // Koneksi database
                                $conn = new mysqli("localhost", "root", "", "logistik");

                                // Cek koneksi
                                if ($conn->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }

                                // Query untuk mendapatkan daftar pengguna
                                $sql = "SELECT username, email, departemen, role FROM user";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                  $no = 1;
                                  while($row = $result->fetch_assoc()) {
                                      echo "<tr>
                                              <td>".$row["username"]."</td>
                                              <td>".$row["email"]."</td>
                                              <td>".$row["departemen"]."</td>
                                              <td>".$row["role"]."</td>
                                              <td>
                                                  <button class='btn btn-danger btn-sm' onclick='confirmDelete(\"".$row["username"]."\")'>Hapus</button>
                                              </td>
                                            </tr>";
                                      $no++;
                                  }
                                } else {
                                    echo "<tr><td colspan='6' class='text-center'>Tidak ada pengguna</td></tr>";
                                }
                                $conn->close();
                            ?>
                        </tbody>
                    </table>

                    <!-- pop-up form -->
                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#tambahUserModal">Tambah User</button>

                    <div class="modal fade" id="tambahUserModal" tabindex="-1" aria-labelledby="tambahUserModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                      <div class="modal-content" style="background-color:rgb(105, 76, 62); color: #ffffff;">

                          <div class="modal-header">
                            <h5 class="modal-title" id="tambahUserModalLabel">Tambah Pengguna Baru</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <form action="proses_tambah_user.php" method="post">
                              <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                              </div>
                              <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                              </div>
                              <div class="mb-3">
                                <label for="departemen" class="form-label">Departemen</label>
                                <input type="text" class="form-control" id="departemen" name="departemen" required>
                              </div>
                              <div class="mb-3">
                                <label for="role" class="form-label">Role</label>
                                <select class="form-control" id="role" name="role" required>
                                  <option value="admin">Admin</option>
                                  <option value="user">User</option>
                                </select>
                              </div>
                              <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                              </div>
                              <button type="submit" class="btn btn-danger btn-sm">Tambah User</button>
                            </form>
                          </div>
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
                          Designed By <a href="https://htmlcodex.com">HTML Codex</a>
                          <br>Distributed By: <a href="https://themewagon.com" target="_blank">ThemeWagon</a>
                      </div>
                  </div>
              </div>
          </div>
          <!-- Footer End -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
      </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.all.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete(username) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Anda tidak dapat mengembalikan ini!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Redirect ke proses_hapus_user.php jika pengguna mengonfirmasi
            window.location.href = 'proses_hapus_user.php?username=' + username;
        }
    });
}
</script>
</body>

</html>
