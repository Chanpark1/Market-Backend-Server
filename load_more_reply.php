<?php
header('Content-Type: application/json; charset=utf8');
error_reporting(E_ALL);
ini_set("display_errors", 1);
date_default_timezone_set('Asia/Seoul');
include("dbconn.php");
$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");

$post_authNum = $_POST['post_authNum'];
$count = $_POST['count'];
$count_int = (int)$count;


$sql = 
"SELECT *
FROM reply
WHERE post_authNum = '$post_authNum'
AND replyIdx < '$count_int'
ORDER BY replyIdx DESC
LIMIT 10
";

$result_reply = mysqli_query($conn, $sql);
$data = array();
while($row = mysqli_fetch_assoc($result_reply)) {

    $authNum = $row['authNum'];

    $sql_user = 
    "SELECT * 
    FROM User
    WHERE authNum = '$authNum'
    ";

    $result_user = mysqli_query($conn,$sql_user);
    $rows = mysqli_fetch_assoc($result_user);
    array_push($data,
    array(
        'replyIdx' => $row['replyIdx'],
        'content' => $row['content'],
        'authNum' => $row['authNum'],
        'post_authNum' => $row['post_authNum'],
        'reply_authNum' => $row['reply_authNum'],
        'created' => $row['created'],
        'like_num' => $row['like_num'],
        'image_path' => $row['path'],
        'username' => $rows['userName'],
        'user_path' => $rows['userImage'],
        'area' => $rows['Area']
    ));
$json = json_encode($data, JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE);

}
echo $json;



?>