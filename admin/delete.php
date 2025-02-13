<?php
session_start(); // Start the session to store messages
require '../db/db_connect.php';

if (isset($_GET['table']) && isset($_GET['id'])) {
    $table = $_GET['table'];
    $id = $_GET['id'];

    // Check if the table is 'cities'
    if ($table === 'cities') {
        // First, delete related records in the 'bus_stops' table
        $conn->query("DELETE FROM bus_stops WHERE city_id = $id");

        // Then, delete related records in the 'routes' table
        $conn->query("DELETE FROM routes WHERE from_city_id = $id OR to_city_id = $id");
    }

    // Check if the table is 'buses'
    if ($table === 'buses') {
        // First, delete related records in the 'schedules' table
        $conn->query("DELETE FROM schedules WHERE bus_id = $id");
    }

    // Check if the table is 'routes'
    if ($table === 'routes') {
        // First, delete related records in the 'bus_stops' table
        $conn->query("DELETE FROM bus_stops WHERE route_id = $id");

        // Then, delete related records in the 'schedules' table
        $conn->query("DELETE FROM schedules WHERE route_id = $id");
    }

    // Check if the table is 'bus_companies'
    if ($table === 'bus_companies') {
        // First, delete related records in the 'buses' table
        $conn->query("DELETE FROM buses WHERE company_id = $id");
    }

    // Now, delete the record from the specified table
    $sql = "DELETE FROM $table WHERE id = $id";
    if ($conn->query($sql)) {
        // Success message
        $_SESSION['message'] = [
            'type' => 'success',
            'text' => ucfirst($table) . ' deleted successfully!'
        ];
    } else {
        // Error message
        $_SESSION['message'] = [
            'type' => 'error',
            'text' => 'Failed to delete ' . ucfirst($table) . '. Error: ' . $conn->error
        ];
    }
}

// Redirect to the appropriate page based on the table
if ($table === 'cities') {
    header("Location: manage_cities.php");
} elseif ($table === 'buses') {
    header("Location: manage_buses.php");
} elseif ($table === 'routes') {
    header("Location: manage_routes.php");
} elseif ($table === 'bus_companies') {
    header("Location: manage_companies.php");
} else {
    header("Location: dashboard.php"); // Fallback redirect
}
exit();
?>