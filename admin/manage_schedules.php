<?php
include "admin_auth.php";
require '../db/db_connect.php';

// Handle form submission to add a schedule
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bus_id = $_POST['bus_id'];
    $route_id = $_POST['route_id'];
    $departure_time = $_POST['departure_time'];
    $arrival_time = $_POST['arrival_time'];
    $ticket_price = $_POST['ticket_price'];

    $sql = "INSERT INTO schedules (bus_id, route_id, departure_time, arrival_time, ticket_price) 
            VALUES ($bus_id, $route_id, '$departure_time', '$arrival_time', $ticket_price)";
    $conn->query($sql);
}

// Fetch schedules
$result = $conn->query("SELECT schedules.*, buses.name AS bus_name, routes.id AS route_id 
                        FROM schedules 
                        JOIN buses ON schedules.bus_id = buses.id
                        JOIN routes ON schedules.route_id = routes.id");

$buses = $conn->query("SELECT * FROM buses");
$routes = $conn->query("SELECT * FROM routes");
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
                        <h1>Manage Schedules</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                            <li class="breadcrumb-item active">Manage Schedules</li>
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
                                <h3 class="card-title">Schedules List</h3>
                                <!-- Add Schedule Button and Search Bar -->
                                <div class="card-tools d-flex align-items-center">
                                    <!-- Add Schedule Button -->
                                    <button type="button" class="btn btn-primary mr-2" data-toggle="modal"
                                        data-target="#addScheduleModal">
                                        <i class="fas fa-plus"></i> Add Schedule
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
                                            <th>Bus</th>
                                            <th>Route ID</th>
                                            <th>Departure</th>
                                            <th>Arrival</th>
                                            <th>Price</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = $result->fetch_assoc()) { ?>
                                            <tr>
                                                <td><?= $row["id"] ?></td>
                                                <td><?= $row["bus_name"] ?></td>
                                                <td><?= $row["route_id"] ?></td>
                                                <td><?= $row["departure_time"] ?></td>
                                                <td><?= $row["arrival_time"] ?></td>
                                                <td>$<?= $row["ticket_price"] ?></td>
                                                <td>
                                                    <a href="delete.php?table=schedules&id=<?= $row["id"] ?>"
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

    <!-- Add Schedule Modal -->
    <div class="modal fade" id="addScheduleModal" tabindex="-1" role="dialog" aria-labelledby="addScheduleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addScheduleModalLabel">Add New Schedule</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Add Schedule Form -->
                    <form method="POST">
                        <div class="form-group">
                            <label for="bus_id">Bus</label>
                            <select class="form-control" id="bus_id" name="bus_id" required>
                                <?php while ($bus = $buses->fetch_assoc()) { ?>
                                    <option value="<?= $bus['id'] ?>"><?= $bus['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="route_id">Route</label>
                            <select class="form-control" id="route_id" name="route_id" required>
                                <?php while ($route = $routes->fetch_assoc()) { ?>
                                    <option value="<?= $route['id'] ?>">Route ID: <?= $route['id'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="departure_time">Departure Time</label>
                            <input type="datetime-local" class="form-control" id="departure_time" name="departure_time"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="arrival_time">Arrival Time</label>
                            <input type="datetime-local" class="form-control" id="arrival_time" name="arrival_time"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="ticket_price">Ticket Price</label>
                            <input type="number" class="form-control" id="ticket_price" name="ticket_price" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Schedule</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Footer -->
    <?php include 'footer.php'; ?>
</div>
<!-- ./wrapper -->

</html>