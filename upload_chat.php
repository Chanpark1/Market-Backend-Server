<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
include("dbconn.php");
$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
header('Content-Type:application/json; charset=utf8');
date_default_timezone_set('Asia/Seoul');

$from_auth = $_POST['from_auth'];
$to_auth = $_POST['to_auth'];
$post_authNum = $_POST['post_authNum'];
$message = $_POST['message'];
$date = date("Y-m-d H:i:s");

$rand = rand(1,2147483647);
$sql_room =
"SELECT room_auth
FROM chat_room
WHERE from_auth = '$from_auth'
AND to_auth = '$to_auth'
AND post_authNum = '$post_authNum'
";

$sql_room2 = 
"SELECT room_auth
FROM chat_room
WHERE from_auth = '$to_auth'
AND to_auth = '$from_auth'
AND post_authNum = '$post_authNum'
";

$result_room2 = mysqli_query($conn, $sql_room2);
$room_auth2 = mysqli_fetch_array($result_room2);


$result_room = mysqli_query($conn, $sql_room);
$room_auth = mysqli_fetch_array($result_room);
if(!isset($room_auth['room_auth']) && !isset($room_auth2)) {
    $sql_insert = 
    "INSERT INTO chat_room(from_auth, to_auth, post_authNum,room_auth)
    VALUES('$from_auth','$to_auth','$post_authNum','$rand')
    ";

    $result_insert = mysqli_query($conn, $sql_insert);

    $sql_insert2 = 
    "INSERT INTO chat_room(from_auth, to_auth, post_authNum, room_auth,created)
    VALUES('$to_auth','$from_auth','$post_authNum','$rand','$date')
    ";

    $result_insert2 = mysqli_query($conn,$sql_insert2);


    $sql_message = 
    "INSERT INTO chat_message(from_auth, to_auth, created, content, room_auth, post_auth)
    VALUES('$from_auth','$to_auth','$date','$message','$rand', '$post_authNum')
    ";

    $result_message = mysqli_query($conn, $sql_message);

    $msg = $rand;
} else {
    $sql_rand = 
    "SELECT room_auth 
    FROM chat_room
    WHERE to_auth = '$to_auth'
    AND from_auth = '$from_auth'
    AND post_authNum = '$post_authNum'
    ";

    

    $result_ran = mysqli_query($conn, $sql_rand);
    $rows = mysqli_fetch_array($result_ran);
    $msg = $rows['room_auth'];

    $sql_msg = 
    "INSERT INTO chat_message(from_auth, to_auth, created,content, room_auth, post_auth)
    VALUES('$from_auth','$to_auth','$date','$message','$msg', '$post_authNum')
    ";

    $result_msg = mysqli_query($conn,$sql_msg);

    // if(isset($row['room_auth'])) {

    //     $sql_username = 
    //     "SELECT userName
    //     FROM User
    //     WHERE authNum = '$from_auth'
    //     ";

    //     $result_username = mysqli_query($conn, $sql_username);
        
    //     $username = mysqli_fetch_array($result_username);

    //     $message = $row['room_auth'];

        
    // }
    

}
echo $msg;
//to_auth 와 getAuthNum() 값과 다르면 분리하는 걸로?



?>