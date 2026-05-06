<?php
include 'db.php';

$id = $_GET['id'];
$conn->query("DELETE FROM affected_people WHERE person_id=$id");

header("Location: report.php");
?>