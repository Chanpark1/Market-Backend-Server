<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
include("dbconn.php");
$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
header('Content-Type:application/json; charset=utf8');

$authNum = $_POST['authNum'];
$post_authNum = $_POST['post_authNum'];

$sql = 
"SELECT post_authNum
FROM community_wishlist
WHERE authNum = '$authNum'
AND post_authNum = '$post_authNum'
";

$result = mysqli_query($conn,$sql);
$data = mysqli_fetch_array($result);

echo isset($data['post_authNum']) ? "O" : "X";
?>