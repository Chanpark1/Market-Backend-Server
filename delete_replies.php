<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
date_default_timezone_set('Asia/Seoul');
header('Content-Type: application/json; charset=utf8');
include("dbconn.php");

$post_authNum = $_POST['post_authNum'];
$reply_authNum = $_POST['reply_authNum'];
$replyIdx = $_POST['replyIdx'];

$sql_del_path =
"SELECT del_path
FROM reply_reply
WHERE post_authNum = '$post_authNum'
AND reply_authNum = '$reply_authNum'
AND replyIdx = '$replyIdx'
";

$result_del_path = mysqli_query($conn, $sql_del_path);

while($row = mysqli_fetch_array($result_del_path)) {
    if(isset($row['del_path'])) {
        unlink($row['del_path']);
    }
}

$sql_del = 
"DELETE FROM reply_reply
WHERE post_authNum = '$post_authNum'
AND reply_authNum = '$reply_authNum'
AND replyIdx = '$replyIdx'
";

$result_del = mysqli_query($conn, $sql_del);

$sql_update = 
"UPDATE community_post
SET reply_num = reply_num - 1
WHERE post_authNum = '$post_authNum'
";

$result_update = mysqli_query($conn, $sql_update);



?>