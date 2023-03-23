<?php
include("dbconn.php");

header('Content-Type: application/json; charset=utf8');
$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");


$authNum = $_POST['authNum'];

$sql_query = 
"SELECT idx,Area,Longitude,Latitude
FROM set_address 
WHERE userAuthNum = '$authNum'
";

$data = array();

$result = mysqli_query($conn,$sql_query);

while($row = mysqli_fetch_assoc($result)) {

    array_push($data,
    array('idx' => $row['idx'],
        'Area' => $row['Area'],
    'Longitude' => $row['Longitude'],
    'Latitude' => $row['Latitude']

));

$json = json_encode($data, JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE);
}

echo $json;

?>