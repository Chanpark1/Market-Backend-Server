<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
include("dbconn.php");
$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
header('Content-Type:application/json; charset=utf8');

$authNum = $_POST['authNum'];
$post_authNum = $_POST['post_authNum'];


$sql = 
"SELECT userName
FROM User
WHERE authNum = '$authNum'
";

$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($result);

echo $row['userName'];


?>