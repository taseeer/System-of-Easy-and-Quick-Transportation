<?php
session_start();
require '../db/db_connect.php';

if (!isset($_SESSION['otp'])) {
    header("Location: forgot_password.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_otp = $_POST['otp'];

    if ($user_otp == $_SESSION['otp']) {
        // OTP is correct, redirect to reset password page
        header("Location: reset_password.php");
        exit();
    } else {
        $error = "Invalid OTP!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Verify OTP</title>
  <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>Admin</b> Panel</a>
  </div>
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Enter the OTP sent to your email</p>

      <?php if (isset($error)) echo "<p style='color:red; text-align: center;'>$error</p>"; ?>

      <form action="" method="POST">
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="otp" placeholder="OTP" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-key"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Verify OTP</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="../admin/assets/plugins/jquery/jquery.min.js"></script>
<script src="../admin/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../admin/assets/dist/js/adminlte.min.js"></script>
</body>
</html>