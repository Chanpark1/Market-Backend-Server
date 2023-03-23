<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include("dbconn.php");


$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");


header('Content-Type:application/json; charset=utf8');

$id = $_POST['post_authNum'];

$sql = "SELECT * FROM post WHERE post_authNum = '$id';";

if(!empty($id) && empty($_COOKIE['Post_'.$id])) {
  $sql_hit = "UPDATE post Set hit_num = hit_num + 1 WHERE post_authNum ='$id';";
  $result_hit = mysqli_query($conn,$sql_hit);
  if(empty($result_hit)) {
 
  } else {
    setcookie('Post_'.$id, true,time()+(60*60*24),'/');
  }
}
?>