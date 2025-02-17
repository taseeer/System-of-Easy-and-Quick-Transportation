<?php
// Secure session settings
session_set_cookie_params([
    'lifetime' => 0, // Session lasts until the browser closes
    'secure' => true, // Only send cookies over HTTPS
    'httponly' => true, // Prevent JavaScript access
    'samesite' => 'Strict' // Mitigate CSRF
]);

session_start(); // Start session with secure settings
session_regenerate_id(true); // Prevent session fixation

// Check if the admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
?>
