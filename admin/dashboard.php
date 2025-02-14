<?php 
include "admin_auth.php"; 
include "../db/db_connect.php"; 

// Fetch dynamic counts using MySQLi
$cities_result = $conn->query("SELECT COUNT(*) FROM cities");
$cities_count = $cities_result->fetch_row()[0];

$buses_result = $conn->query("SELECT COUNT(*) FROM buses");
$buses_count = $buses_result->fetch_row()[0];

$routes_result = $conn->query("SELECT COUNT(*) FROM routes");
$routes_count = $routes_result->fetch_row()[0];

$schedules_result = $conn->query("SELECT COUNT(*) FROM schedules");
$schedules_count = $schedules_result->fetch_row()[0];

$companies_result = $conn->query("SELECT COUNT(*) FROM bus_companies");
$companies_count = $companies_result->fetch_row()[0];?>
<!-- Include Header -->
<?php include 'header.php'; ?>

<div class="wrapper">
    <!-- Include Sidebar -->
    <?php include 'sidebar.php'; ?>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a></li>
            <li class="nav-item"><a href="dashboard.php" class="nav-link">Home</a></li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item"><a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </nav>

    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6"><h1>Manage Dashboard</h1></div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3><?php echo $cities_count; ?></h3>
                                <p>Cities</p>
                            </div>
                            <a href="manage_cities.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3><?php echo $buses_count; ?></h3>
                                <p>Buses</p>
                            </div>
                            <a href="manage_buses.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3><?php echo $routes_count; ?></h3>
                                <p>Routes</p>
                            </div>
                            <a href="manage_routes.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3><?php echo $schedules_count; ?></h3>
                                <p>Schedules</p>
                            </div>
                            <a href="manage_schedules.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3><?php echo $companies_count; ?></h3>
                                <p>Companies</p>
                            </div>
                            <a href="manage_schedules.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>

                
            </div>
        </section>
        <?php include 'footer.php'; ?>
    </div>

 
</div>
