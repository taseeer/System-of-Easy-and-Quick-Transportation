<?php
include "admin_auth.php";
require '../db/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $city_name = $_POST['city_name'];
    $sql = "INSERT INTO cities (name) VALUES ('$city_name')";
    $conn->query($sql);
}

// Fetch cities
$result = $conn->query("SELECT * FROM cities");
?>

<!-- Include Header -->
<?php include 'header.php'; ?>
<div class="wrapper">

    <!-- Sidebar -->
    <?php include 'sidebar.php'; ?>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Manage Cities</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/FYP/admin/dashboard.php">Home</a></li>
                            <li class="breadcrumb-item active">Manage Cities</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main Content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Cities List</h3>
                                <!-- Add City Button and Search Bar -->
                                <div class="card-tools d-flex align-items-center">
                                    <!-- Add City Button -->
                                    <button type="button" class="btn btn-primary mr-2" data-toggle="modal"
                                        data-target="#addCityModal">
                                        <i class="fas fa-plus"></i> Add City
                                    </button>
                                    <!-- Search Bar -->
                                    <div class="input-group input-group-sm" style="width: 200px;">
                                        <input type="text" name="table_search" class="form-control float-right"
                                            placeholder="Search">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>City Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = $result->fetch_assoc()) { ?>
                                            <tr>
                                                <td><?= $row["id"] ?></td>
                                                <td><?= $row["name"] ?></td>
                                                <td>
                                                    <a href="delete.php?table=cities&id=<?= $row["id"] ?>"
                                                        class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                <!-- /.row -->
            </div>
        </section>
    </div>
    <!-- /.content-wrapper -->

    <!-- Add City Modal -->
    <div class="modal fade" id="addCityModal" tabindex="-1" role="dialog" aria-labelledby="addCityModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCityModalLabel">Add New City</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Add City Form -->
                    <form method="POST">
                        <div class="form-group">
                            <label for="city_name">City Name</label>
                            <input type="text" class="form-control" id="city_name" name="city_name" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add City</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'footer.php'; ?>
</div>
<!-- ./wrapper -->

</body>

</html>