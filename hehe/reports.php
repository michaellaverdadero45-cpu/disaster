<?php include 'db.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Full Disaster Report</title>
    <style>
        table { border-collapse: collapse; width: 100%; margin-bottom: 30px;}
        th, td { border: 1px solid #000; padding: 10px; text-align: center;}
        h2 { background: #2c3e50; color: white; padding: 10px;}
    </style>
</head>
<body>

<!-- DISASTER REPORTS -->
<h2>Disaster Reports</h2>
<table>
<tr>
    <th>ID</th>
    <th>Type</th>
    <th>Location</th>
    <th>Date</th>
    <th>Damage</th>
</tr>

<?php
$res = $conn->query("SELECT * FROM disaster_report");
while($row = $res->fetch_assoc()){
    echo "<tr>
        <td>{$row['report_id']}</td>
        <td>{$row['disaster_type']}</td>
        <td>{$row['location']}</td>
        <td>{$row['date']}</td>
        <td>{$row['damage_level']}</td>
    </tr>";
}
?>
</table>


<!-- EVACUATION CENTERS -->
<h2>Evacuation Centers</h2>
<table>
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Capacity</th>
    <th>Location</th>
</tr>

<?php
$res = $conn->query("SELECT * FROM evacuation_center");
while($row = $res->fetch_assoc()){
    echo "<tr>
        <td>{$row['center_id']}</td>
        <td>{$row['center_name']}</td>
        <td>{$row['capacity']}</td>
        <td>{$row['location']}</td>
    </tr>";
}
?>
</table>


<!-- AFFECTED PEOPLE -->
<h2>Affected People</h2>
<table>
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Age</th>
    <th>Evacuation Center</th>
</tr>

<?php
$res = $conn->query("SELECT * FROM affected_people");
while($row = $res->fetch_assoc()){
    echo "<tr>
        <td>{$row['person_id']}</td>
        <td>{$row['name']}</td>
        <td>{$row['age']}</td>
        <td>{$row['evacuation_center']}</td>
    </tr>";
}
?>
</table>

</body>
</html>