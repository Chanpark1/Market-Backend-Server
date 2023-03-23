<?php
header('Content-Type: application/json; charset=utf8');
error_reporting(E_ALL);
ini_set("display_errors", 1);
date_default_timezone_set('Asia/Seoul');
include("dbconn.php");

$auth = $_POST['authNum'];
$date = date("Y-m-d H:i:s");
$sql_check = 
"SELECT authNum
FROM service_manager
WHERE authNum = '$auth'
";

$result_check = mysqli_query($conn, $sql_check);

$row = mysqli_fetch_array($result_check);

$data = array();

if(!isset($row['authNum'])) {
    $sql_input = 
    "INSERT INTO service_manager(authNum, destroyed)
    VALUES('$auth','$date')
    ";

    $result_input = mysqli_query($conn, $sql_input);
} 
else {

    $sql_update =
    "UPDATE service_manager
    SET destroyed = '$date'
    WHERE authNum = '$auth'
    ";

    $result_update = mysqli_query($conn, $sql_update);
}

echo "xxxx";



?>