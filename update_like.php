<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include("dbconn.php");

$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");

header('Content-Type:application/json; charset=utf8');

$post_authNum = $_POST['post_authNum'];
$authNum = $_POST['authNum'];
$sql = 
"SELECT post_authNum
FROM wishlist
WHERE authNum = '$authNum'
AND post_authNum = '$post_authNum'
";
$result_sql = mysqli_query($conn,$sql);

$data = mysqli_fetch_array($result_sql);

if(isset($data['post_authNum'])) {
    $sql_del = 
    "DELETE FROM wishlist
    WHERE post_authNum = '$post_authNum'
    ";
    $del_update =
    "UPDATE post
    SET like_num = like_num-1
    WHERE post_authNum = '$post_authNum'
    ";
    if($result_del = mysqli_query($conn,$sql_del)) {
        $msg = "-";
        $result_del_update = mysqli_query($conn,$del_update);
    }
 
} else { 
    $sql_add = 
    "INSERT INTO wishlist(authNum,post_authNum)
    VALUES('{$authNum}','{$post_authNum}')
    ";

    $add_update = 
    "UPDATE post
    SET like_num = like_num + 1
    WHERE post_authNum = '$post_authNum'
    ";

    if($result_add = mysqli_query($conn, $sql_add)){
     $msg = "+";

     $result_add_update = mysqli_query($conn,$add_update);
    }
}
echo $msg;




?>