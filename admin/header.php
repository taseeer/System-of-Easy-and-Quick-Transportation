<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../admin/assets/plugins/fontawesome-free/css/all.min.css">
    <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="../admin/assets/plugins/bootstrap/css/bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../admin/assets/dist/css/adminlte.min.css">
    <style>
.toast-container {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 9999;
}

.toast {
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    transition: opacity 0.3s ease-in-out;
}

.toast-body {
    display: flex;
    align-items: center;
    padding: 10px 15px;
}

.toast-body i {
    font-size: 1.5rem;
}

.btn-close {
    opacity: 0.8;
}

.btn-close:hover {
    opacity: 1;
}
</style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
 <!-- Toast Notification -->


    <!-- Toast Container -->
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
        <?php if (isset($_SESSION['message'])) { ?>
            <div class="toast align-items-center text-white bg-<?= $_SESSION['message']['type'] === 'success' ? 'success' : 'danger' ?> border-3 border-dark" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
                <div class="d-flex">
                    <div class="toast-body fw-bold">
                        <i class="fas <?= $_SESSION['message']['type'] === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle' ?> me-2"></i>
                        <?= $_SESSION['message']['text'] ?>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        <?php
            unset($_SESSION['message']); // Clear the message after displaying
        } ?>
    </div>
</div>