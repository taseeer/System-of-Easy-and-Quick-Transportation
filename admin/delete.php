<?php
session_start(); // Start the session to store messages
require '../db/db_connect.php';

// Function to set session messages
function setMessage($type, $text) {
    $_SESSION['message'] = [
        'type' => $type,
        'text' => $text
    ];
}

// Function to check if a city can be deleted (no foreign key constraints)
function canDeleteCity($conn, $cityId) {
    // Check if there are any dependent records in bus_stops or routes
    $busStopsQuery = $conn->prepare("SELECT COUNT(*) FROM bus_stops WHERE city_id = ?");
    $busStopsQuery->bind_param("i", $cityId);
    $busStopsQuery->execute();
    $busStopsQuery->bind_result($busStopsCount);
    $busStopsQuery->fetch();
    $busStopsQuery->close();

    $routesQuery = $conn->prepare("SELECT COUNT(*) FROM routes WHERE from_city_id = ? OR to_city_id = ?");
    $routesQuery->bind_param("ii", $cityId, $cityId);
    $routesQuery->execute();
    $routesQuery->bind_result($routesCount);
    $routesQuery->fetch();
    $routesQuery->close();

    return ($busStopsCount == 0 && $routesCount == 0);
}

if (isset($_GET['table']) && isset($_GET['id'])) {
    $table = $_GET['table'];
    $id = (int)$_GET['id']; // Ensure ID is an integer

    try {
        // Check if the table is valid
        $validTables = ['cities', 'buses', 'routes', 'bus_companies'];
        if (!in_array($table, $validTables)) {
            throw new Exception("Invalid table specified.");
        }

        // Handle city deletion separately due to foreign key constraints
        if ($table === 'cities') {
            if (!canDeleteCity($conn, $id)) {
                // Set a red toast message for foreign key constraint violation
                setMessage('error', 'Cannot delete city. It is referenced in other records.');
                header("Location: manage_cities.php");
                exit();
            }

            // Delete related records in bus_stops and routes
            $conn->begin_transaction(); // Start a transaction
            $conn->query("DELETE FROM bus_stops WHERE city_id = $id");
            $conn->query("DELETE FROM routes WHERE from_city_id = $id OR to_city_id = $id");
        }

        // Handle buses deletion
        if ($table === 'buses') {
            $conn->query("DELETE FROM schedules WHERE bus_id = $id");
        }

        // Handle routes deletion
        if ($table === 'routes') {
            $conn->query("DELETE FROM bus_stops WHERE route_id = $id");
            $conn->query("DELETE FROM schedules WHERE route_id = $id");
        }

        // Handle bus_companies deletion
        if ($table === 'bus_companies') {
            $conn->query("DELETE FROM buses WHERE company_id = $id");
        }

        // Delete the record from the specified table
        $sql = "DELETE FROM $table WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            if ($table === 'cities') {
                $conn->commit(); // Commit the transaction if city deletion is successful
            }
            setMessage('success', ucfirst($table) . ' deleted successfully!');
        } else {
            throw new Exception("Failed to delete " . ucfirst($table) . ". Error: " . $conn->error);
        }

        $stmt->close();
    } catch (Exception $e) {
        if ($table === 'cities') {
            $conn->rollback(); // Rollback the transaction if city deletion fails
        }
        setMessage('error', $e->getMessage());
    }
}

// Redirect to the appropriate page based on the table
$redirectPages = [
    'cities' => 'manage_cities.php',
    'buses' => 'manage_buses.php',
    'routes' => 'manage_routes.php',
    'bus_companies' => 'manage_companies.php'
];

$redirectPage = $redirectPages[$table] ?? 'dashboard.php'; // Fallback to dashboard
header("Location: $redirectPage");
exit();
?>