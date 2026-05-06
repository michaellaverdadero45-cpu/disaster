<?php
include 'db.php';

$id = $_GET['id'];
$conn->query("DELETE FROM disaster_reports WHERE report_id=$id");

header("Location: report.php");
?>