<?php
header('Content-Type: application/json; charset=utf8');
error_reporting(E_ALL);
ini_set("display_errors", 1);
include("dbconn.php");
date_default_timezone_set('Asia/Seoul');

$authNum = $_POST['authNum'];
$date = date("Y-m-d H:i:s");

$sql_date = 
"SELECT destroyed
FROM service_manager
WHERE authNum = '$authNum' 
";

$result_date = mysqli_query($conn, $sql_date);

$date_row = mysqli_fetch_array($result_date);
$time = $date_row['destroyed'];
if(isset($time)) {
    $sql = 
    "SELECT *
    FROM chat_message
    WHERE to_auth = '$authNum'
    AND created > '$time'
    ";
    
    $result = mysqli_query($conn,$sql);
    
    $data = array();
    
    while($row = mysqli_fetch_array($result)) {
        array_push($data, array(
            'content' => $row['content']
        ));
    
        $count = count($data);
    }
    
    $sql_del =
    "DELETE FROM service_manager
    WHERE authNum = '$authNum'
    ";
    
    $result_del = mysqli_query($conn,$sql_del);
    
    echo strval($count);
}


?>