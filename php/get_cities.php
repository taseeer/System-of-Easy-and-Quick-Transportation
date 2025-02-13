<?php
require '../db/db_connect.php';

$sql = "SELECT * FROM cities";
$result = $conn->query($sql);

$cities = [];
while ($row = $result->fetch_assoc()) {
    $cities[] = $row;
}

echo json_encode($cities);
$conn->close();
?>
