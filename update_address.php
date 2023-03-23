<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include("dbconn.php");


$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");

$authNum = $_POST['authNum'];
$area3 = $_POST['Area3'];
$area4 = $_POST['Area4'];
$longitude = $_POST['Longitude'];
$latitude = $_POST['Latitude'];

$sql_query = 
"INSERT INTO set_address(userAuthNum,Area,Longitude,Latitude) 
VALUES('$authNum',Concat('$area3',' ', '$area4'), $longitude,$latitude)
";

if($result = mysqli_query($conn,$sql_query)) {
    $message = "DB Successfully Updated";
} else {
    $message = "DB Insert Failed";
}

echo $message;


?>