<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
include("dbconn.php");
$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
header('Content-Type:application/json; charset=utf8');

$authNum = $_POST['authNum'];
$post_authNum = $_POST['post_authNum'];

$sql = 
"SELECT post_authNum
FROM wishlist
WHERE authNum = '$authNum'
AND post_authNum = '$post_authNum'
";
// POST로 받은 authNum과 DB에 있는 authNum을 비교해서
// 해당하는 post_authNum을 가져온다.
$result = mysqli_query($conn,$sql);
$data = mysqli_fetch_array($result);

// authNum에 해당하는 post_authNum 값들

// if(in_array($post_authNum,$data)) {
//     $message = "O";
// } else {
//     $message = "X";
// }

echo isset($data['post_authNum']) ? "O" : "X";
// echo $message;

?>