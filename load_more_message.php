<?php
header('Content-Type: application/json; charset=utf8');
error_reporting(E_ALL);
ini_set("display_errors", 1);
date_default_timezone_set('Asia/Seoul');
include("dbconn.php");

$from_authNum = $_POST['from_auth'];
$to_authNum = $_POST['to_auth'];
$post_auth = $_POST['post_auth'];
$room_auth = $_POST['room_auth'];
$count = $_POST['count'];

$count_int = (int)$count;

$data = array();

$sql_message = 
"SELECT *
FROM chat_message
WHERE room_auth = '$room_auth'
AND post_auth = '$post_auth'
AND idx < '$count_int'
ORDER BY idx DESC
LIMIT 10
";

$result_message = mysqli_query($conn, $sql_message);

while($row = mysqli_fetch_assoc($result_message)) {
    if($row['to_auth'] == $to_authNum) {
        $view = 0;
    } else {
        $view = 1;
    }

    $sql_user = 
    "SELECT userImage
    FROM User
    WHERE authNum = '$to_authNum'
    ";

    $result_user = mysqli_query($conn,$sql_user);

    $img = mysqli_fetch_array($result_user);

    array_push($data,
    array(
        'idx' => $row['idx'],
        'to_auth' => $row['to_auth'],
        'from_auth' => $row['from_auth'],
        'created' => $row['created'],
        'content' => $row['content'],
        'userImage' => $img['userImage'],
        'ViewType' => $view
    ));

    $json = json_encode($data, JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE);
}

echo $json;







?>