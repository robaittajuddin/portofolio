<?php
session_start();
session_destroy();

if (isset($_POST['btnLogin'])) {
    $konek = mysqli_connect("localhost", "root", "", "logistik");
    if (!$konek) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $username = mysqli_real_escape_string($konek, $_POST['txUsername']);
    $email = mysqli_real_escape_string($konek, $_POST['txEmail']); // Ambil email
    $password = mysqli_real_escape_string($konek, $_POST['txPassword']);

    // Query untuk memeriksa kredensial pengguna
    $sql_login = "SELECT * FROM user WHERE username='$username' AND email='$email' AND password='$password'";
    $query_login = mysqli_query($konek, $sql_login);

    if ($query_login) {
        $data_login = mysqli_fetch_array($query_login, MYSQLI_BOTH);
        $jumlah_login = mysqli_num_rows($query_login);

        if ($jumlah_login === 1) {
            session_start();
            $_SESSION["ses_username"] = $data_login['username'];
            $_SESSION["ses_status"] = $data_login['role'];
            echo "<meta http-equiv='refresh' content='0; url=index.php'>";
            exit();
        } else {
            session_destroy();
            echo "<script>alert('Login Failed');</script>";
            echo "<meta http-equiv='refresh' content='0; url=login.php'>";
            exit();
        }
    } else {
        echo "Error: " . $sql_login . "<br>" . mysqli_error($konek);
    }

    mysqli_close($konek);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>RSU Nurussyifa - Login</title>
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

    <!-- Sign In Start -->
    <div class="container-fluid">
      <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
          <div class="bg-secondary rounded p-4 p-sm-5 my-4 mx-3">
            <div class="d-flex align-items-center justify-content-between mb-3">
              <h3>Login</h3>
            </div>
            <form class="row g-3 needs-validation" method="POST" action="" novalidate>
  <div class="col-12">
    <label for="yourUsername" class="form-label">Username</label>
    <div class="input-group has-validation">
      <input type="text" name="txUsername" class="form-control" required>
      <div class="invalid-feedback">Please enter your username.</div>
    </div>
  </div>
  <div class="col-12">
    <label for="yourEmail" class="form-label">Email</label>
    <div class="input-group has-validation">
      <input type="email" name="txEmail" class="form-control" required>
      <div class="invalid-feedback">Please enter your email.</div>
    </div>
  </div>
  <div class="col-12">
    <label for="yourPassword" class="form-label">Password</label>
    <input type="password" name="txPassword" class="form-control" required>
    <div class="invalid-feedback">Please enter your password!</div>
  </div>

  <div class="col-12">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
      <label class="form-check-label" for="rememberMe">Remember me</label>
    </div>
  </div>
  <div class="col-12">
    <button class="btn btn-primary w-100" type="submit" name="btnLogin">Login</button>
  </div>
  <div class="col-12">
    <p class="small mb-0">Tidak mempunyai akun? hubungin team IT</p>
  </div>
</form>
          </div>
        </div>
      </div>
    </div>
    <!-- Sign In End -->
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

  <!-- Template Javascript -->
  <script src="js/main.js"></script>
</body>

</html>