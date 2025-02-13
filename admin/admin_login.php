<?php
session_start();
require '../db/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Dummy admin credentials (Change this to use database authentication)
    if ($username === "admin" && $password === "1234") {
        $_SESSION['admin'] = true;
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid Username or Password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin Panel | Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- AdminLTE Theme -->
  <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <style>
    /* Center the login box better */
    .login-box {
        width: 400px;
    }

    /* Improve input fields */
    .input-group .form-control {
        height: 45px;
        font-size: 16px;
    }

    /* Adjust the login button */
    .btn-primary {
        background-color: #007bff;
        border-color: #0056b3;
        font-size: 16px;
        font-weight: bold;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #004099;
    }

    /* Error message styling */
    p.error-message {
        color: red;
        font-weight: bold;
        text-align: center;
    }

    /* Improve the checkbox alignment */
    .icheck-primary {
        display: flex;
        align-items: center;
    }

    /* Login box shadow effect */
    .card {
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
    }

    /* Improve overall page background */
    body {
        background-color: rgb(59, 107, 178);
    }

    /* Forgot password link styling */
    .forgot-password-link {
        text-align: center;
        margin-top: 15px;
    }

    .forgot-password-link a {
        color: #007bff;
        text-decoration: none;
    }

    .forgot-password-link a:hover {
        text-decoration: underline;
    }
  </style>
</head>

<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>Admin</b> Panel</a>
  </div>
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <?php if (isset($error)) echo "<p style='color:red; text-align: center;'>$error</p>"; ?>

      <form action="" method="POST">
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="username" placeholder="Username" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">Remember Me</label>
            </div>
          </div>
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
        </div>
      </form>

      <!-- Forgot Password Link -->
      <div class="forgot-password-link">
        <a href="forgot_password.php">Forgot Password?</a>
      </div>
    </div>
  </div>
</div>

<!-- jQuery -->
<script src="assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="assets/dist/js/adminlte.min.js"></script>

</body>
</html>