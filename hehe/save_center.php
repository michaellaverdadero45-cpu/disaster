<?php
include 'db.php';

$name = $_POST['center_name'];
$capacity = $_POST['capacity'];
$location = $_POST['location'];

$conn->query("INSERT INTO evacuation_center 
(center_name, capacity, location)
VALUES ('$name', '$capacity', '$location')");

header("Location: reports.php");
?>