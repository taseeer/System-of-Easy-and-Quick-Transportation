<?php
session_start();
require '../db/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $remember = isset($_POST['remember']);

    // Prepare and execute the query to fetch admin details
    $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $admin['password'])) {
            $_SESSION['admin'] = true;
            $_SESSION['admin_username'] = $username; // Add this line
            // If "Remember Me" is checked, store credentials in cookies
            if ($remember) {
                setcookie("admin_username", $username, time() + (86400 * 30), "/"); // 30 days
                setcookie("admin_password", $password, time() + (86400 * 30), "/"); // 30 days
            } else {
                // If not checked, delete any existing cookies
                setcookie("admin_username", "", time() - 3600, "/");
                setcookie("admin_password", "", time() - 3600, "/");
            }

            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Invalid Username or Password!";
        }
    } else {
        $error = "Invalid Username or Password!";
    }
}

// Retrieve saved username & password from cookies (if available)
$savedUsername = isset($_COOKIE['admin_username']) ? $_COOKIE['admin_username'] : "";
$savedPassword = isset($_COOKIE['admin_password']) ? $_COOKIE['admin_password'] : "";

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
        /* Center the login box */
        .login-box { width: 400px; }

        /* Improve input fields */
        .input-group .form-control { height: 45px; font-size: 16px; }

        /* Adjust the login button */
        .btn-primary {
            background-color: #007bff;
            border-color: #0056b3;
            font-size: 16px;
            font-weight: bold;
        }

        .btn-primary:hover { background-color: #0056b3; border-color: #004099; }

        /* Error message styling */
        p.error-message { color: red; font-weight: bold; text-align: center; margin-bottom: 1rem; }

        /* Improve checkbox alignment */
        .icheck-primary { display: flex; align-items: center; }

        /* Box shadow effect */
        .card { box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2); }

        /* Page background */
        body {
            background: linear-gradient(135deg, rgb(35, 148, 23) 0%, #2a5298 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        /* Forgot password link styling */
        .forgot-password-link { text-align: center; margin-top: 15px; }
        .forgot-password-link a { color: #007bff; text-decoration: none; }
        .forgot-password-link a:hover { text-decoration: underline; }

        /* Login Logo */
        .login-logo { text-align: center; margin-bottom: 20px; }
        .login-logo a { color: #fff; font-size: 2.5rem; font-weight: bold; text-decoration: none; }
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

            <?php if (isset($error)) echo "<p class='error-message'>$error</p>"; ?>

            <form action="" method="POST">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="username" placeholder="Username" value="<?= $savedUsername ?>" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" name="password" placeholder="Password" value="<?= $savedPassword ?>" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" id="remember" name="remember" <?= ($savedUsername && $savedPassword) ? 'checked' : '' ?>>
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