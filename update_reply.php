<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
include("dbconn.php");
$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
header('Content-Type:application/json; charset=utf8');
date_default_timezone_set('Asia/Seoul');

$post_authNum = $_POST['post_authNum'];
$reply_authNum = $_POST['reply_authNum'];

$content = $_POST['content'];

$sql_con =
"UPDATE reply
SET content = '$content'
WHERE post_authNum = '$post_authNum'
AND reply_authNum = '$reply_authNum'
";

$result_con = mysqli_query($conn,$sql_con);


if(isset($_FILES['uploaded_file']['name'])) {

    $sql_del_path = 
    "SELECT path
    FROM reply
    WHERE post_authNum = '$post_authNum'
    AND reply_authNum = '$reply_authNum'
    ";

    $result_del_path = mysqli_query($conn, $sql_del_path);

    $row = mysqli_fetch_assoc($result_del_path);

    $del_path = $row['path'];
    if(isset($del_path)) {
        $real_del = str_replace('http://3.36.34.173','.',$del_path);
        unlink($real_del);
    }

        $basename = basename($_FILES['uploaded_file']['name']);

        $tmp_file = $_FILES['uploaded_file']['tmp_name'];
    
        move_uploaded_file($tmp_file,"./replyImage/".$basename);

        $sql_update_image =
        "UPDATE reply
        SET path = 'http://3.36.34.173/replyImage/".$basename."',
        del_path = './replyImage/".$basename."'
        WHERE post_authNum = '$post_authNum'
        AND reply_authNum = '$reply_authNum'
        ";

        $result_update = mysqli_query($conn, $sql_update_image);
    
} else if($_POST['isDeleted'] == "YES") {

    $sql_un =
    "SELECT del_path
    FROM reply
    WHERE post_authNum = '$post_authNum'
    AND reply_authNum = '$reply_authNum'
    ";

    $result_un = mysqli_query($conn, $sql_un);
    if($rows = mysqli_fetch_array($result_un)) {
        unlink($rows['del_path']);

        $sql_del = 
        "UPDATE reply
        SET path = NULL,
        del_path = NULL
        WHERE post_authNum = '$post_authNum'
        AND reply_authNum = '$reply_authNum'
        ";

        $result_del = mysqli_query($conn, $sql_del);

    };



}

?>