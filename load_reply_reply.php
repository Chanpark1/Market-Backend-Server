<?php
header('Content-Type: application/json; charset=utf8');
error_reporting(E_ALL);
ini_set("display_errors", 1);
date_default_timezone_set('Asia/Seoul');
include("dbconn.php");
$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");

$post_authNum = $_POST['post_authNum'];
$reply_authNum = $_POST['reply_authNum'];



$sql_main = 
"SELECT *
FROM reply_reply
WHERE post_authNum = '$post_authNum'
AND reply_authNum = '$reply_authNum'
ORDER BY replyIdx DESC
LIMIT 5
";

$result = mysqli_query($conn, $sql_main);

$data = array();

while($row = mysqli_fetch_assoc($result)) {

    $sql_count = 
    "SELECT replyIdx
    FROM reply_reply
    WHERE post_authNum = '$post_authNum'
    AND reply_authNum = '$reply_authNum'
    ORDER BY replyIdx DESC
    ";
    $data_count = array();

    $result_count = mysqli_query($conn,$sql_count);

    while($rowss = mysqli_fetch_assoc($result_count)) {
        array_push($data_count,
        array(
            'replyIdx' => $rowss['replyIdx']
        ));
        $count_final = count($data_count);
    };  
   
    $user_authNum = $row['authNum'];

    $sql_user =
    "SELECT *
    FROM User
    WHERE authNum = '$user_authNum'
    ";

    $result_user = mysqli_query($conn, $sql_user);

    $rows = mysqli_fetch_assoc($result_user);

    array_push($data,
    array(
        'replyIdx' => $row['replyIdx'],
        'reply_authNum' => $row['reply_authNum'],
        'post_authNum' => $row['post_authNum'],
        'authNum' => $row['authNum'],
        'content' => $row['content'],
        'image_path' => $row['path'],
        'created' => $row['created'],
        'like_num' => $row['like_num'],
        'username' => $rows['userName'],
        'user_path' => $rows['userImage'],
        'area' => $rows['Area'],
        'count' => $count_final
    ));

    $json = json_encode($data, JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE);
}

echo $json;



?>