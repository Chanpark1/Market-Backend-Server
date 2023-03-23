<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
include("dbconn.php");
$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
header('Content-Type:application/json; charset=utf8');


$post_authNum = $_POST['post_authNum'];

$sql = 
"UPDATE community_post
SET hit_num = hit_num + 1
WHERE post_authNum = '$post_authNum'
";


$result = mysqli_query($conn, $sql);

?>