<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
include("dbconn.php");
$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
header('Content-Type:application/json; charset=utf8');

$from_auth = $_POST['from_authNum'];
$to_auth = $_POST['to_authNum'];
$post_auth = $_POST['post_authNum'];
$sql1 =
"SELECT room_auth
FROM chat_room
WHERE to_auth = '$to_auth'
AND from_auth = '$from_auth'
AND post_authNum = '$post_auth'
";


$result1 = mysqli_query($conn, $sql1);


while($key1 = mysqli_fetch_array($result1)) {
    $auth1 = $key1['room_auth'];

    $sql2 =
    "SELECT room_auth
    FROM chat_room
    WHERE to_auth = '$from_auth'
    AND from_auth = '$to_auth'
    AND post_authNum = '$post_auth'
    ";

    $result2 = mysqli_query($conn, $sql2);
    while($key2 = mysqli_fetch_array($result2)) {
        $auth2 = $key2['room_auth'];

        if($auth1 == $auth2) {
            $auth_final = $auth1;
        }

    }
}


echo $auth_final;







?>