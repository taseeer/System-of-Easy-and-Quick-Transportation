<?php
include "admin_auth.php";
require '../db/db_connect.php';

// Handle form submission to add a company
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $company_name = $_POST['company_name'];
    $contact_info = $_POST['contact_info'];

    $sql = "INSERT INTO bus_companies (name, contact_info) VALUES ('$company_name', '$contact_info')";
    $conn->query($sql);
}

// Fetch bus companies
$result = $conn->query("SELECT * FROM bus_companies");
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
                        <h1>Manage Bus Companies</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                            <li class="breadcrumb-item active">Manage Bus Companies</li>
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
                                <h3 class="card-title">Bus Companies List</h3>
                                <!-- Add Company Button and Search Bar -->
                                <div class="card-tools d-flex align-items-center">
                                    <!-- Add Company Button -->
                                    <button type="button" class="btn btn-primary mr-2" data-toggle="modal"
                                        data-target="#addCompanyModal">
                                        <i class="fas fa-plus"></i> Add Company
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
                                            <th>Name</th>
                                            <th>Contact Info</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = $result->fetch_assoc()) { ?>
                                            <tr>
                                                <td><?= $row["id"] ?></td>
                                                <td><?= $row["name"] ?></td>
                                                <td><?= $row["contact_info"] ?></td>
                                                <td>
                                                    <a href="delete.php?table=bus_companies&id=<?= $row["id"] ?>"
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

    <!-- Add Company Modal -->
    <div class="modal fade" id="addCompanyModal" tabindex="-1" role="dialog" aria-labelledby="addCompanyModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCompanyModalLabel">Add New Company</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Add Company Form -->
                    <form method="POST">
                        <div class="form-group">
                            <label for="company_name">Company Name</label>
                            <input type="text" class="form-control" id="company_name" name="company_name" required>
                        </div>
                        <div class="form-group">
                            <label for="contact_info">Contact Info</label>
                            <input type="text" class="form-control" id="contact_info" name="contact_info" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Company</button>
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