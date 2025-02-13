<?php
include "admin_auth.php";
require '../db/db_connect.php';

// Handle form submission to add a bus
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bus_name = $_POST['bus_name'];
    $bus_type = $_POST['bus_type'];
    $total_seats = $_POST['total_seats'];
    $company_id = $_POST['company_id'];

    $sql = "INSERT INTO buses (name, bus_type, total_seats, company_id) VALUES ('$bus_name', '$bus_type', $total_seats, $company_id)";
    $conn->query($sql);
}

// Fetch buses and companies
$result = $conn->query("SELECT buses.*, bus_companies.name AS company_name FROM buses JOIN bus_companies ON buses.company_id = bus_companies.id");
$companies = $conn->query("SELECT * FROM bus_companies");
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
                        <h1>Manage Buses</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                            <li class="breadcrumb-item active">Manage Buses</li>
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
                                <h3 class="card-title">Buses List</h3>
                                <!-- Add Bus and Add Company Buttons -->
                                <div class="card-tools d-flex align-items-center">
                                    <!-- Add Bus Button -->
                                    <button type="button" class="btn btn-primary mr-2" data-toggle="modal"
                                        data-target="#addBusModal">
                                        <i class="fas fa-plus"></i> Add Bus
                                    </button>
                                    <!-- Add Company Button -->
                                    <a href="manage_companies.php" class="btn btn-success mr-2">
                                        <i class="fas fa-building"></i> Add Company
                                    </a>
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
                                            <th>Name</th>
                                            <th>Type</th>
                                            <th>Seats</th>
                                            <th>Company</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = $result->fetch_assoc()) { ?>
                                            <tr>
                                                <td><?= $row["id"] ?></td>
                                                <td><?= $row["name"] ?></td>
                                                <td><?= $row["bus_type"] ?></td>
                                                <td><?= $row["total_seats"] ?></td>
                                                <td><?= $row["company_name"] ?></td>
                                                <td>
                                                    <a href="delete.php?table=buses&id=<?= $row["id"] ?>"
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

    <!-- Add Bus Modal -->
    <div class="modal fade" id="addBusModal" tabindex="-1" role="dialog" aria-labelledby="addBusModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBusModalLabel">Add New Bus</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Add Bus Form -->
                    <form method="POST">
                        <div class="form-group">
                            <label for="bus_name">Bus Name</label>
                            <input type="text" class="form-control" id="bus_name" name="bus_name" required>
                        </div>
                        <div class="form-group">
                            <label for="bus_type">Bus Type</label>
                            <select class="form-control" id="bus_type" name="bus_type" required>
                                <option value="AC">AC</option>
                                <option value="Non-AC">Non-AC</option>
                                <option value="Luxury">Luxury</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="total_seats">Total Seats</label>
                            <input type="number" class="form-control" id="total_seats" name="total_seats" required>
                        </div>
                        <div class="form-group">
                            <label for="company_id">Bus Company</label>
                            <select class="form-control" id="company_id" name="company_id" required>
                                <?php while ($company = $companies->fetch_assoc()) { ?>
                                    <option value="<?= $company['id'] ?>"><?= $company['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Bus</button>
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