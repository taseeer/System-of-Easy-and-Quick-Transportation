<?php
session_start();
include '../db/db_connect.php';

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

$adminId = $_SESSION['admin'];
$sql = "SELECT * FROM admins WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $adminId);
$stmt->execute();
$result = $stmt->get_result();
$adminData = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Profile</title>
    <!-- AdminLTE3 CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body class="hold-transition sidebar-mini">
    <!-- Include Header -->
    <?php include 'header.php'; ?>
    <!-- Include Sidebar -->
    <?php include 'sidebar.php'; ?>

    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Admin Profile</h1>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main Content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Profile Information</h3>
                                <button id="editBtn" class="btn btn-sm btn-warning float-right">Edit</button>
                            </div>
                            <form id="profileForm" action="update_profile.php" method="post" enctype="multipart/form-data">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="name">Name:</label>
                                        <input type="text" id="name" name="name" class="form-control" value="<?php echo $adminData['name']; ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email:</label>
                                        <input type="email" id="email" name="email" class="form-control" value="<?php echo $adminData['email']; ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="profile_pic">Profile Picture:</label>
                                        <div class="mb-2">
                                            <img src="<?php echo $adminData['profile_pic']; ?>" alt="Profile Picture" class="img-thumbnail" style="width: 100px; height: 100px;">
                                        </div>
                                        <input type="file" id="profile_pic" name="profile_pic" class="form-control-file" disabled>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" id="saveBtn" class="btn btn-primary" disabled>Save Changes</button>
                                    <button type="button" id="cancelBtn" class="btn btn-secondary" disabled>Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
                     <!-- Include Footer -->
         <?php include 'footer.php'; ?>
        </section>

    </div>
    <!--./wrapper -->

   

   
    <!-- Custom Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const editBtn = document.getElementById('editBtn');
            const saveBtn = document.getElementById('saveBtn');
            const cancelBtn = document.getElementById('cancelBtn');
            const formInputs = document.querySelectorAll('#profileForm input');
            const profilePicInput = document.getElementById('profile_pic');

            // Toggle edit mode
            editBtn.addEventListener('click', function () {
                formInputs.forEach(input => {
                    input.readOnly = !input.readOnly;
                });
                profilePicInput.disabled = !profilePicInput.disabled;
                saveBtn.disabled = !saveBtn.disabled;
                cancelBtn.disabled = !cancelBtn.disabled;
            });

            // Cancel edit mode
            cancelBtn.addEventListener('click', function () {
                formInputs.forEach(input => {
                    input.readOnly = true;
                });
                profilePicInput.disabled = true;
                saveBtn.disabled = true;
                cancelBtn.disabled = true;
                // Reset form values to original data
                document.getElementById('name').value = "<?php echo $adminData['name']; ?>";
                document.getElementById('email').value = "<?php echo $adminData['email']; ?>";
            });
        });
    </script>
</body>
</html>