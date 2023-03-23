<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include("dbconn.php");

header('Content-Type: application/json; charset=utf8');

$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");

$text = $_POST['text'];

$sql_query = 
"SELECT Longitude, Latitude, Area3, Area4, CONCAT(Area1, ' ',  Area2, ' ' ,Area3, ' ' ,Area4) AS result
    FROM areas_korea
    WHERE Area3
    LIKE '%$text%'
";

$data = array();

$result = mysqli_query($conn,$sql_query);

while($row = mysqli_fetch_assoc($result)) {

    array_push($data,
    array('result' => $row['result'],
    'Area3' => $row['Area3'],
    'Area4' => $row['Area4'],
    'Longitude' => $row['Longitude'],
    'Latitude' => $row['Latitude']
));


$jsons = json_encode($data,JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE);
}

echo $jsons;


?>