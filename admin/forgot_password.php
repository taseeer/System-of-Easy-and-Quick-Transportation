<?php
session_start();
require '../config.php';
require '../db/db_connect.php';
require '../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Generate CSRF token if not set
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Check if request is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("CSRF validation failed!");
    }

    $email = trim($_POST['email']);

    $stmt = $conn->prepare("SELECT id FROM admins WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $otp = random_int(100000, 999999); // Secure OTP generation
        $_SESSION['otp_hash'] = password_hash($otp, PASSWORD_BCRYPT);
        $_SESSION['email'] = $email;
        $_SESSION['otp_expiry'] = time() + 300; // OTP valid for 5 minutes

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = getenv('SMTP_HOST');
            $mail->SMTPAuth = true;
            $mail->Username = getenv('SMTP_USERNAME');
            $mail->Password = getenv('SMTP_PASSWORD');
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom(getenv('SMTP_USERNAME'), 'Admin Panel');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Password Reset OTP';
            $mail->Body = "Your OTP for password reset is: <b>$otp</b>. It expires in 5 minutes.";

            $mail->send();
            header("Location: verify_otp.php");
            exit();
        } catch (Exception $e) {
            $error = "Failed to send OTP. Please try again. Error: " . $mail->ErrorInfo;
        }
    } else {
        $error = "Email not found!";
    }
}
?>



<!DOCTYPE html>
<html>
<head>
  <title>Forgot Password</title>
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
      <p class="login-box-msg">Enter your email to reset your password</p>

      <?php if (isset($error)) echo "<p style='color:red; text-align: center;'>$error</p>"; ?>

      <form action="" method="POST">
  <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
  
  <div class="input-group mb-3">
    <input type="email" class="form-control" name="email" placeholder="Email" required>
    <div class="input-group-append">
      <div class="input-group-text">
        <span class="fas fa-envelope"></span>
      </div>
    </div>
  </div>
  
  <div class="row">
    <div class="col-12">
      <button type="submit" class="btn btn-primary btn-block">Send OTP</button>
    </div>
  </div>
</form>

    </div>
  </div>
</div>

<script src="assets/plugins/jquery/jquery.min.js"></script>
<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/dist/js/adminlte.min.js"></script>
</body>
</html>