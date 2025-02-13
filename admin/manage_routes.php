<?php
include "admin_auth.php";
require '../db/db_connect.php';

// Handle form submission to add a route
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $from_city_id = $_POST['from_city_id'];
    $to_city_id = $_POST['to_city_id'];
    $distance = $_POST['distance'];

    $sql = "INSERT INTO routes (from_city_id, to_city_id, distance) VALUES ($from_city_id, $to_city_id, $distance)";
    $conn->query($sql);
}

// Fetch routes
$result = $conn->query("SELECT routes.*, c1.name AS from_city, c2.name AS to_city 
                        FROM routes 
                        JOIN cities c1 ON routes.from_city_id = c1.id 
                        JOIN cities c2 ON routes.to_city_id = c2.id");

$cities = $conn->query("SELECT * FROM cities");
?>

<!-- Include Header -->
<?php include 'header.php'; ?>
<div class="wrapper">
    <!-- Include Sidebar -->
    <?php include 'sidebar.php'; ?>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Manage Routes</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                            <li class="breadcrumb-item active">Manage Routes</li>
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
                                <h3 class="card-title">Routes List</h3>
                                <!-- Add Route Button and Search Bar -->
                                <div class="card-tools d-flex align-items-center">
                                    <!-- Add Route Button -->
                                    <button type="button" class="btn btn-primary mr-2" data-toggle="modal"
                                        data-target="#addRouteModal">
                                        <i class="fas fa-plus"></i> Add Route
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
                                <!-- Pagination and Rows per Page Dropdown -->
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <!-- Rows per Page Dropdown -->
                                    <div class="form-group mb-0">
                                        <label for="rowsPerPage" class="mr-2">Rows per page:</label>
                                        <select class="form-control form-control-sm" id="rowsPerPage"
                                            style="width: 80px;">
                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                        </select>
                                    </div>
                                    <!-- Pagination -->
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination pagination-sm mb-0">
                                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                                        </ul>
                                    </nav>
                                </div>
                                <!-- Table -->
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>From</th>
                                            <th>To</th>
                                            <th>Distance (KM)</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = $result->fetch_assoc()) { ?>
                                            <tr>
                                                <td><?= $row["id"] ?></td>
                                                <td><?= $row["from_city"] ?></td>
                                                <td><?= $row["to_city"] ?></td>
                                                <td><?= $row["distance"] ?> km</td>
                                                <td>
                                                    <a href="delete.php?table=routes&id=<?= $row["id"] ?>"
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
            </div>
        </section>
    </div>
    <!-- /.content-wrapper -->

    <!-- Add Route Modal -->
    <div class="modal fade" id="addRouteModal" tabindex="-1" role="dialog" aria-labelledby="addRouteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRouteModalLabel">Add New Route</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Add Route Form -->
                    <form method="POST">
                        <div class="form-group">
                            <label for="from_city_id">From City</label>
                            <select class="form-control" id="from_city_id" name="from_city_id" required>
                                <?php while ($city = $cities->fetch_assoc()) { ?>
                                    <option value="<?= $city['id'] ?>"><?= $city['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="to_city_id">To City</label>
                            <select class="form-control" id="to_city_id" name="to_city_id" required>
                                <?php mysqli_data_seek($cities, 0);
                                while ($city = $cities->fetch_assoc()) { ?>
                                    <option value="<?= $city['id'] ?>"><?= $city['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="distance">Distance (KM)</label>
                            <input type="number" class="form-control" id="distance" name="distance" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Route</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Footer -->
    <?php include 'footer.php'; ?>
</div>
<!-- ./wrapper -->
</body>

</html>