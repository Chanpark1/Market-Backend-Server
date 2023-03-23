<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include("dbconn.php");

$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");

header('Content-Type:application/json; charset=utf8');

$authNum = $_POST['authNum'];

$sql_query = 
"SELECT Area, Longitude, Latitude
From User
Where authNum = '$authNum'
";

$result = mysqli_query($conn,$sql_query);

$data = array();

while($row = mysqli_fetch_assoc($result)) {
    array_push($data,
    array('Area' => trim($row['Area']),
   'Longitude' => $row['Longitude'],
   'Latitude' => $row['Latitude']
));

$json = json_encode($data, JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE);

}

echo $json;








?>