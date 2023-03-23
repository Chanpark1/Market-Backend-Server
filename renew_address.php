<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

include("dbconn.php");

header('Content-Type: application/json; charset=utf8');

$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");

$authNum = $_POST['authNum'];
$area = $_POST['area'];
$longitude = $_POST['longitude'];
$latitude = $_POST['latitude'];

$sql_query = 
"UPDATE User
SET Area = '$area', Longitude = '$longitude', Latitude = '$latitude'
WHERE authNum = '$authNum'
";


if($result = mysqli_query($conn,$sql_query)) {
    $message = "data inserted";
} else {
    $message = "failed";
}

echo $message;

?>