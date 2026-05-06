<?php
include 'db.php';

$id = $_GET['id'];
$conn->query("DELETE FROM evacuation_centers WHERE center_id=$id");

header("Location: report.php");
?>