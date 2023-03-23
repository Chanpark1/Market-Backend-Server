<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
include("dbconn.php");
$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
header('Content-Type:application/json; charset=utf8');

$post_authNum = $_POST['post_authNum'];

$sql_get_image = 
"SELECT path
FROM post_img
WHERE post_authNum = '$post_authNum'
";

$result_image = mysqli_query($conn,$sql_get_image);

$images = array();

while($row = mysqli_fetch_assoc($result_image)) {
    array_push($images,$row['path']);

    for($i = 0; $i < count($images); $i++) {

        $del_for_query = $images[$i];

        $real_del = str_replace('http://3.36.34.173','.',$images[$i]);

        if(unlink($real_del)) {
            echo "디렉토리 파일 삭제 성공";
        }
    }
}


$sql_delete =
"DELETE FROM post
WHERE post_authNum = '$post_authNum'
";
if($result_delete = mysqli_query($conn, $sql_delete)) {
    echo "db삭제 성공";
} else {
    echo "db삭제 실패";
}





?>