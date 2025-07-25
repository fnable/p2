<?php
$hostName = "localhost";
$userName = "root";
$password = "";
$databaseName = "barangaydb";
$conn = new mysqli($hostName, $userName, $password, $databaseName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$region = $_POST['region'];

$queryCities = "SELECT DISTINCT city FROM barangay_listing WHERE region = '$region'";
$resultCities = $conn->query($queryCities);

$output = '<option value="0">---Select City---</option>';
while ($row = $resultCities->fetch_assoc()) {
    $output .= "<option value='" . $row['city'] . "'>" . $row['city'] . "</option>";
}

echo $output;
?>
