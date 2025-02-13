<?php
require '../db/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $picking_point = $_POST['picking-point'];
    $dropping_point = $_POST['dropping-point'];
    $date = $_POST['date'];

    $sql = "SELECT buses.name AS bus_name, schedules.departure_time, schedules.ticket_price
            FROM schedules
            JOIN routes ON schedules.route_id = routes.id
            JOIN buses ON schedules.bus_id = buses.id
            WHERE routes.from_city_id = ? AND routes.to_city_id = ? 
            AND DATE(schedules.departure_time) = ?
            ORDER BY schedules.departure_time ASC"; 

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $picking_point, $dropping_point, $date);
    $stmt->execute();
    $result = $stmt->get_result();

    $buses = [];
    while ($row = $result->fetch_assoc()) {
        $buses[] = $row;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Buses</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/FYP/php/header.php'); ?>


<div class="container">
    <h2>Available Buses</h2>

    <?php if (!empty($buses)) { ?>
        <?php foreach ($buses as $bus) { ?>
            <div class="bus-card">
                <div class="bus-details">
                    <span class="bus-name"><?php echo $bus['bus_name']; ?></span>
                    <span class="departure-time"><i class="fas fa-clock"></i> Departure: <?php echo date('h:i A', strtotime($bus['departure_time'])); ?></span>
                    <span class="ticket-price"><i class="fas fa-tag"></i> Price: Rs. <?php echo number_format($bus['ticket_price'], 2); ?></span>
                </div>
                <button class="select-seat">Select Seat</button>
            </div>
        <?php } ?>
    <?php } else { ?>
        <p>No buses available for this route on the selected date.</p>
    <?php } ?>
</div>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/FYP/php/footer.php'); ?>
</body>
</html>
