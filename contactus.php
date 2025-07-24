<html>
<head>
    <title>Contact Us</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body style="font-size:15px;font-family:sans-serif;padding:0px;margin:0px;">

<?php
$hostName = "localhost";
$userName = "root";
$password = "";
$databaseName = "barangaydb";
$conn = new mysqli($hostName, $userName, $password, $databaseName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$region = isset($_POST['region']) ? $_POST['region'] : '';


$queryRegion = "SELECT DISTINCT region FROM barangay_listing";
$resultRegion = $conn->query($queryRegion);

$cities = array();

?>

<div style="min-width:300px;width:80%;margin:20px auto auto auto;border:1px solid black;padding:10px;">
    <h1 style="font-size:30px;font-weight:bolder;font-family:arial">Contact Us</h1>

    <form action="" method="" id="ContactUs">
        <h2 style="font-size:20px;font-weight:bolder;font-family:arial;margin-left:2%;">Personal Information</h2>
		<input value="" placeholder="Field 1" name="" style="display:block;min-width:280px;width:80%;padding:5px;height:30px;margin:10px auto 0% auto;">
		<input value="" placeholder="Field 2" name="" style="display:block;min-width:280px;width:80%;padding:5px;height:30px;margin:10px auto 0% auto;">
		<input value="" placeholder="Field 3" name="" style="display:block;min-width:280px;width:80%;padding:5px;height:30px;margin:10px auto 0% auto;">
		<input value="" placeholder="Field 4" name="" style="display:block;min-width:280px;width:80%;padding:5px;height:30px;margin:10px auto 0% auto;">
		<input value="" placeholder="Field 5" name="" style="display:block;min-width:280px;width:80%;padding:5px;height:30px;margin:10px auto 0% auto;">
        <h2 style="font-size:20px;font-weight:bolder;font-family:arial;margin-left:2%;">Address</h2>
        <select name="region" id="region" style="display:block;min-width:280px;width:80%;padding:5px;height:30px;margin:10px auto 0% auto;">
            <option value="0">---Select Region---</option>
            <?php
            while ($row = $resultRegion->fetch_assoc()) {
                echo "<option value='" . $row['region'] . "'>" . $row['region'] . "</option>";
            }
            ?>
        </select>

        <select name="city" id="city" style="display:block;min-width:280px;width:80%;padding:5px;height:30px;margin:10px auto 0% auto;">
            <option value="0">---Select City---</option>
        </select>

        <select name="barangay" id="barangay" style="display:block;min-width:280px;width:80%;padding:5px;height:30px;margin:10px auto 0% auto;">
            <option value="0">---Select Barangay---</option>
        </select>
<input value="" placeholder="Street/Building" name="" style="display:block;min-width:280px;width:80%;padding:5px;height:30px;margin:10px auto 0% auto;">
<h2 style="font-size:20px;font-weight:bolder;font-family:arial;margin-left:2%;">Message/Comment</h2>
<textarea style="display:block;min-width:280px;width:80%;padding:5px;height:200px;margin:10px auto 0% auto;"></textarea>
<button type="submit" form="ContactUs" value="Submit" style="display:block;min-width:280px;width:80%;padding:5px;height:40px;margin:10px auto 0% auto;font-face:Arial;font-size:20px;background-color:#aaa;">Submit Message</button>
</form>
</div>

<script>
    var cityArray = [];

    function populateCities() {
    var region = $("#region").val();
    $.ajax({
        url: "get_cities.php",
        type: "POST",
        data: { region: region },
        success: function (response) {
            var regex = /'([^']+)'/g;
            var matches = response.match(regex) || [];

            cityArray = matches.map(function (match) {
                return match.replace(/'/g, '');
            });

            console.log("city array length = " + cityArray.length);

            $("#city").html(response);
            var firstCity = cityArray[0];
            $("#city").val(firstCity);
            populateBarangays();
        }
    });
}

    function populateBarangays() {
    var city = $("#city").val();
    $.ajax({
        url: "get_barangays.php",
        type: "POST",
        data: { city: city },
        success: function (response) {
            var regex = /'([^']+)'/g;
            var matches = response.match(regex) || [];

            var barangayArray = matches.map(function (match) {
                return match.replace(/'/g, '');
            });

            console.log("barangay array length = " + barangayArray.length);

            $("#barangay").html(response);
            
            var firstBarangay = barangayArray[0];
            $("#barangay").val(firstBarangay);
        }
    });
}

    $("#region").change(function () {
        populateCities();
    });

    $("#city").change(function () {
        populateBarangays();
    });

</script>

</body>
</html>
