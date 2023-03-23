<?php
header('Content-Type: application/json; charset=utf8');
error_reporting(E_ALL);
ini_set("display_errors", 1);
include("dbconn.php");
date_default_timezone_set('Asia/Seoul');

$room_auth = $_POST['room_auth'];
$to_auth = $_POST['to_auth'];
$from_auth = $_POST['from_auth'];
$post_auth = $_POST['post_auth'];
$count_str = $_POST['count'];

$count = (int)$count_str;

$date = date("Y-m-d H:i:s");

// $sql_insert = 
// "INSERT INTO chat_message(from_auth, to_auth, created, content, room_auth, post_auth)
// VALUES('$from_auth','$to_auth','$date','')
// "

$file_path = "./chatImage";
$fn = date("ymdHis");
if(isset($FILES['uploaded_file0']['name'])) {
    for($i = 0; $i < $count; $i++) {
        $basename = basename($_FILES['uploaded_file'.$i]['name']);
        $file_path = $file_path.$basename;
        if(isset($_FILES['uploaded_file'.$i])) {
            move_uploaded_file($_FILES['uploaded_file'.$i]['tmp_name'],"./chatImage/".$fn.$basename);

            $sql_insert = 
            "INSERT INTO chat_message(from_auth, to_auth, created, content, room_auth, post_auth)
            VALUES('$from_auth','$to_auth','$date','http://3.36.34.173/chatImage/".$fn.$basename."','$room_auth','$post_auth')
            ";

            $result_insert = mysqli_query($conn,$sql_insert);

        }
    }
}


?>