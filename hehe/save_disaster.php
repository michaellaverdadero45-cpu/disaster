<?php
include 'db.php';

$type = $_POST['disaster_type'];
$location = $_POST['location'];
$date = $_POST['date'];
$damage = $_POST['damage_level'];

$conn->query("INSERT INTO disaster_report
(disaster_type, location, date, damage_level)
VALUES ('$type', '$location', '$date', '$damage')");

header("Location: reports.php");
?>