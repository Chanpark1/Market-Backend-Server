<?php
include('dbconn.php');
$phoneNum = $_POST['phone'];

$sql = "SELECT * FROM User WHERE userPhoneNo = '$phoneNum'";

$result = mysqli_query($conn,$sql);

$data = mysqli_fetch_array($result);

echo isset($data['userPhoneNo']) ? $data['authNum'] : "O";




?>