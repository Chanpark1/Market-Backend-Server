<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
include("dbconn.php");
$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
header('Content-Type:application/json; charset=utf8');
date_default_timezone_set('Asia/Seoul');

$post_authNum = $_POST['post_authNum'];
$reply_authNum = $_POST['reply_authNum'];
$replyIdx = $_POST['replyIdx'];

$content = $_POST['content'];

$sql_con = 
"UPDATE reply_reply
SET content = '$content'
WHERE post_authNum = '$post_authNum'
AND reply_authNum = '$reply_authNum'
AND replyIdx = '$replyIdx'
";

$result_con = mysqli_query($conn,$sql_con);

if(isset($_FILES['uploaded_file']['name'])) {

    $sql_del_path = 
    "SELECT del_path
    FROM reply_reply
    WHERE post_authNum = '$post_authNum'
    AND reply_authNum = '$reply_authNum'
    AND replyIdx = '$replyIdx'
    ";

    $result_del_path = mysqli_query($conn, $sql_del_path);

    $row = mysqli_fetch_array($result_del_path);

    $del_path = $row['del_path'];

    if(isset($del_path)) {
        unlink($del_path);
    }

    $basename = basename($_FILES['uploaded_file']['name']);

    $tmp_file = $_FILES['uploaded_file']['tmp_name'];

   if(move_uploaded_file($tmp_file,"./rep_repImage/".$basename)) {
    $sql_update_image = 
    "UPDATE reply_reply
    SET path = 'http://3.36.34.173/rep_repImage/".$basename."',
    del_path = './rep_repImage/".$basename."'
    WHERE post_authNum = '$post_authNum'
    AND reply_authNum = '$reply_authNum'
    AND replyIdx = '$replyIdx'
    ";
    $result_update_image = mysqli_query($conn, $sql_update_image);
   }
} else if ($_POST['isDeleted'] == "YES") {

    $sql_un = 
    "SELECT del_path
    FROM reply_reply
    WHERE post_authNum = '$post_authNum'
    AND reply_authNum = '$reply_authNum'
    AND replyIdx = '$replyIdx'
    ";

    $result_un = mysqli_query($conn, $sql_un);
    $rows = mysqli_fetch_array($result_un);

    if(isset($sql_un)) {
        unlink($rows['del_path']);

        $sql_del =
        "UPDATE reply_reply
        SET path = NULL,
        del_path = NULL
        WHERE post_authNum = '$post_authNum'
        AND reply_authNum = '$reply_authNum'
        AND replyIdx = '$replyIdx'
        ";

        $result_del = mysqli_query($conn, $sql_del);
    }

}


?>