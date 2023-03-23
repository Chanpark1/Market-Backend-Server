<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include("dbconn.php");

$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");



if( ($_SERVER['REQUEST_METHOD'] == 'POST') || $android) {
   
    $authNum = $_POST['authNum'];
    $area = $_POST['area'];
    $longitude = $_POST['longitude'];
    $latitude = $_POST['latitude'];

    $sql= "INSERT INTO set_address(userAuthNum, Area, Longitude, Latitude)
     VALUES ('{$authNum}','{$area}','{$longitude}','{$latitude}')";
$result_query = mysqli_query($conn,$sql);



}


?>
