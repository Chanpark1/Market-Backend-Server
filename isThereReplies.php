<?php
header('Content-Type: application/json; charset=utf8');
error_reporting(E_ALL);
ini_set("display_errors", 1);
date_default_timezone_set('Asia/Seoul');
include("dbconn.php");

$post_authNum = $_POST['post_authNum'];
$reply_authNum = $_POST['reply_authNum'];

$sql = 
"SELECT replyIdx
FROM reply_reply
WHERE post_authNum = '$post_authNum'
AND reply_authNum = '$reply_authNum'
";

$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_array($result);

echo isset($data['replyIdx']) ? "O" : "X";

?>