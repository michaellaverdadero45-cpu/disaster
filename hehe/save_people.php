<?php
include 'db.php';

$name = $_POST['name'];
$age = $_POST['age'];
$person_id = $_POST['person_id'];
$evacuation_center = $_POST['evacuation_center'];

$conn->query("INSERT INTO affected_people 
(name, age, person_id,evacuation_center)
VALUES ('$name', '$age', '$person_id','$evacuation_center')");

header("Location: reports.php");
?>