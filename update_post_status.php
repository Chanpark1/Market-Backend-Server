<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include("dbconn.php");


$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");


header('Content-Type:application/json; charset=utf8');

$status = $_POST['status'];
$post_authNum = $_POST['post_authNum'];

$sql =
"UPDATE post
SET status = '$status'
WHERE post_authNum = '$post_authNum'
";

if($result = mysqli_query($conn, $sql)) {
    $message = "Status Update Success";
}

echo $message;


?>