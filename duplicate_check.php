<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
include('dbconn.php');

$username = $_POST['username'];

$sql = "SELECT idx FROM User Where userName ='$username'";

// POST로 받은 username과 DB에 있는 username들을 비교한다.

$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_array($result);

echo isset($data['idx']) ? "X" : "O";
// 비교해서 똑같은 idx 값이 있다면? 

?>