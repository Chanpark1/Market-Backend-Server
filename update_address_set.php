<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

include("dbconn.php");

$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");

header('Content-Type:application/json; charset=utf8');

$idx = $_POST['idx'];
$area3 = $_POST['area3'];
$area4 = $_POST['area4'];
$longitude = $_POST['longitude'];
$latitude = $_POST['latitude'];

$sql_query = 
"UPDATE set_address SET Area = Concat('$area3', ' ', '$area4'), Longitude = $longitude, 
Latitude = $latitude
WHERE idx = $idx
";

if($result = mysqli_query($conn,$sql_query)) {
    $message = "db updated";
} else {
    $message = "Failed";
}

echo $message;

?>