<?php
session_start();
include '../db/db_connect.php';

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

$adminId = $_SESSION['admin'];
$name = $_POST['name'];

if ($_FILES['profile_pic']['error'] === 0) {
    $targetDir = "../uploads/";
    $targetFile = $targetDir . basename($_FILES['profile_pic']['name']);
    move_uploaded_file($_FILES['profile_pic']['tmp_name'], $targetFile);
    $profilePic = $targetFile;
} else {
    $profilePic = $_SESSION['admin_profile_pic'];
}

$sql = "UPDATE admins SET name = ?, profile_pic = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssi", $name, $profilePic, $adminId);
$stmt->execute();

$_SESSION['admin_name'] = $name;
$_SESSION['admin_profile_pic'] = $profilePic;

header("Location: admin_profile.php");
exit();
?>