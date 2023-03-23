<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
date_default_timezone_set('Asia/Seoul');
header('Content-Type: application/json; charset=utf8');
include("dbconn.php");

$post_authNum = $_POST['post_authNum'];
$reply_authNum = $_POST['reply_authNum'];

$sql_path = 
"SELECT path
FROM reply
WHERE post_authNum = '$post_authNum'
AND reply_authNum = '$reply_authNum'
";

$result_path = mysqli_query($conn, $sql_path);

while($row = mysqli_fetch_assoc($result_path)) {
    if(isset($row['path'])) {

        $real_del = str_replace('http://3.36.34.173','.',$row['path']);

        unlink($real_del);
    }
}

$sql_reps_path = 
"SELECT path
FROM reply_reply
WHERE post_authNum = '$post_authNum'
AND reply_authNum = '$reply_authNum'
";

$result_reps_path = mysqli_query($conn, $sql_reps_path);

while($rows = mysqli_fetch_assoc($result_reps_path)) {
    if(isset($rows['path'])) {

        $real_del = str_replace('http://3.36.34.173','.',$rows['path']);

        unlink($real_del);
    }
}

$sql_del = 
"DELETE FROM reply
WHERE post_authNum = '$post_authNum'
AND reply_authNum = '$reply_authNum'
";

$result_del = mysqli_query($conn, $sql_del);

$sql_del_replies =
"DELETE FROM reply_reply
WHERE post_authNum = '$post_authNum'
AND reply_authNum = '$reply_authNum'
";
$result_del_replied = mysqli_query($conn, $sql_del_replies);

$sql_update = 
"UPDATE community_post
SET reply_num = reply_num -1
WHERE post_authNum = '$post_authNum'
";

$result_update = mysqli_query($conn,$sql_update);


?>
