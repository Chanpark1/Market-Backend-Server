<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

include("dbconn.php");


$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");


header('Content-Type:application/json; charset=utf8');

$post_authNum = $_POST['post_authNum'];
$authNum = $_POST['authNum'];

$sql =
"UPDATE post
SET like_num = like_num - 1
WHERE post_authNum = '$post_authNum'
";

$result = mysqli_query($conn,$sql);

$sql_input = 
"DELETE FROM wishlist
WHERE post_authNum = '$post_authNum'
";

if($result_input = mysqli_query($conn,$sql_input)){
    $message = "DB 삭제됨";
}




echo $message;

?>