<?php
include "admin_auth.php";
require '../db/db_connect.php';
$error = '';
$success = '';
$username = $_SESSION['admin_username'];

$stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();

$showProfileForm = false;
$showPasswordForm = false;

// Handle Profile Update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile'])) {
    $showProfileForm = true; // Keep profile form open
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif (!preg_match("/^[0-9]{10,15}$/", $phone_number)) {
        $error = "Invalid phone number format.";
    } else {
        $updateStmt = $conn->prepare("UPDATE admins SET email = ?, phone_number = ? WHERE username = ?");
        $updateStmt->bind_param("sss", $email, $phone_number, $username);
        if ($updateStmt->execute()) {
            $success = "Profile updated successfully.";
            $showProfileForm = false; // Close form on success
        } else {
            $error = "Failed to update profile.";
        }
    }

    // Handle profile picture upload
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['size'] > 0) {
        $profile_picture = $_FILES['profile_picture'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($profile_picture["name"]);

        if (move_uploaded_file($profile_picture["tmp_name"], $target_file)) {
            $updateStmt = $conn->prepare("UPDATE admins SET profile_pic = ? WHERE username = ?");
            $updateStmt->bind_param("ss", $target_file, $username);
            if ($updateStmt->execute()) {
                $success = "Profile picture updated successfully.";
                $showProfileForm = false; // Close form on success
            }
        } else {
            $error = "Failed to upload profile picture.";
        }
    }
}

// Handle Password Change
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['change_password'])) {
    $showPasswordForm = true; // Keep password form open
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($newPassword !== $confirmPassword) {
        $error = "New password and confirm password do not match.";
    } elseif (password_verify($currentPassword, $admin['password'])) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $updateStmt = $conn->prepare("UPDATE admins SET password = ? WHERE username = ?");
        $updateStmt->bind_param("ss", $hashedPassword, $username);
        if ($updateStmt->execute()) {
            $success = "Password updated successfully.";
            $showPasswordForm = false; // Close form on success
        } else {
            $error = "Failed to update password.";
        }
    } else {
        $error = "Current password is incorrect.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Admin Panel | Settings</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include 'header.php'; ?>
    <style>
        .form-container { display: none; }
        .full-width-btn { width: 100%; margin-bottom: 10px; }
        .toast {
            position: fixed;
            top: 10px;
            right: 10px;
            background: #28a745;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            display: none;
            z-index: 1000;
        }
        .toast.error { background: #dc3545; }
    </style>
</head>
<body>
    <div class="wrapper">
        <?php include 'sidebar.php'; ?>
        <div class="content-wrapper">
            <section class="content-header">
                <h1>Settings</h1>
            </section>
            <section class="content">
                <div class="container-fluid">
                    <button id="showProfileForm" class="btn btn-primary full-width-btn">Update Profile</button>
                    <button id="showPasswordForm" class="btn btn-danger full-width-btn">Change Password</button>

                    <div id="toastContainer">
                        <?php if ($success): ?>
                            <div class="toast" id="successToast"><?= $success ?></div>
                        <?php endif; ?>
                        <?php if ($error): ?>
                            <div class="toast error" id="errorToast"><?= $error ?></div>
                        <?php endif; ?>
                    </div>

                    <div id="profileForm" class="card card-primary form-container" <?php if ($showProfileForm) echo 'style="display:block;"'; ?>>
                        <div class="card-header"><h3>Update Profile</h3></div>
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="card-body">
                                <label>Email:</label>
                                <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($admin['email']) ?>" required>
                                
                                <label>Phone Number:</label>
                                <input type="text" class="form-control" name="phone_number" value="<?= htmlspecialchars($admin['phone_number']) ?>" required>
                                
                                <label>Profile Picture:</label>
                                <input type="file" class="form-control" name="profile_picture">
                                
                                <p>Current Profile Picture:</p>
                                <?php if (!empty($admin['profile_pic'])): ?>
                                    <img src="<?= htmlspecialchars($admin['profile_pic']) ?>" alt="Profile Picture" style="max-width: 100px;">
                                <?php else: ?>
                                    <p>No profile picture uploaded.</p>
                                <?php endif; ?>
                            </div>
                            <button type="submit" name="update_profile" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                    
                    <div id="passwordForm" class="card card-primary form-container" <?php if ($showPasswordForm) echo 'style="display:block;"'; ?>>
                        <div class="card-header"><h3>Change Password</h3></div>
                        <form action="" method="POST">
                            <div class="card-body">
                                <label>Current Password:</label>
                                <input type="password" class="form-control" name="current_password" required>
                                
                                <label>New Password:</label>
                                <input type="password" class="form-control" name="new_password" required>
                                
                                <label>Confirm New Password:</label>
                                <input type="password" class="form-control" name="confirm_password" required>
                            </div>
                            <button type="submit" name="change_password" class="btn btn-danger">Change</button>
                        </form>
                    </div>
                </div>
            </section>
        </div>
        <?php include 'footer.php'; ?>
    </div>
    <script>
        document.getElementById("showProfileForm").addEventListener("click", function() {
    var profileForm = document.getElementById("profileForm");
    var passwordForm = document.getElementById("passwordForm");

    if (profileForm.style.display === "none" || profileForm.style.display === "") {
        profileForm.style.display = "block";
        passwordForm.style.display = "none";
    } else {
        profileForm.style.display = "none";
    }
});

document.getElementById("showPasswordForm").addEventListener("click", function() {
    var profileForm = document.getElementById("profileForm");
    var passwordForm = document.getElementById("passwordForm");

    if (passwordForm.style.display === "none" || passwordForm.style.display === "") {
        passwordForm.style.display = "block";
        profileForm.style.display = "none";
    } else {
        passwordForm.style.display = "none";
    }
});

        function showToast(id) {
            let toast = document.getElementById(id);
            if (toast) {
                toast.style.display = "block";
                setTimeout(() => {
                    toast.style.opacity = "1";
                }, 100);
                setTimeout(() => {
                    toast.style.opacity = "0";
                    setTimeout(() => {
                        toast.style.display = "none";
                    }, 500);
                }, 3000);
            }
        }

        window.onload = function() {
            showToast("successToast");
            showToast("errorToast");
        };
    </script>

</body>
</html>
