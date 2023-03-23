<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

include("dbconn.php");

$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");

$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];

// latitude = 위도 37.1556
// longitude = 경도 126.6816517
header('Content-Type: application/json; charset = utf8');
$sql_query = "SELECT Area1, Area2, Area3,Area4, Longitude,Latitude,
 (6371
*acos(
    cos(radians($latitude))
    *cos(radians(Latitude))
    *cos(radians(Longitude) - radians($longitude))
    +sin(radians($latitude))
    *sin(radians(Latitude))
    )
    ) 
AS distance 
FROM areas_korea 
HAVING distance < 5
ORDER BY distance ASC";

$data = array();

$result = mysqli_query($conn,$sql_query);
while($row = mysqli_fetch_assoc($result)) {

    array_push($data,
    array('Area1' => $row['Area1'],
    'Area2'=> $row['Area2'],
    'Area3' => $row['Area3'],
    'Area4' => $row['Area4'],
    'Longitude' => $row['Longitude'],
    'Latitude' => $row['Latitude']
    ));
    $jsons = json_encode($data, JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE);
    
}

echo $jsons;




?>