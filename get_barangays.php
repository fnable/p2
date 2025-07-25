<?php
$hostName = "localhost";
$userName = "root";
$password = "";
$databaseName = "barangaydb";
$conn = new mysqli($hostName, $userName, $password, $databaseName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$city = $_POST['city'];

$queryBarangays = "SELECT DISTINCT barangayname FROM barangay_listing WHERE city = '$city'";
$resultBarangays = $conn->query($queryBarangays);

$output = '<option value="0">---Select Barangay---</option>';
while ($row = $resultBarangays->fetch_assoc()) {
    $output .= "<option value='" . $row['barangayname'] . "'>" . $row['barangayname'] . "</option>";
}

echo $output;
?>
