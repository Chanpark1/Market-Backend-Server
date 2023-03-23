<?php

include('dbconn.php');

$phoneNum = $_POST['phone'];
$email = $_POST['email'];

$sql = "UPDATE User Set userPhoneNo='$phoneNum' WHERE userEmail = '$email'";

if($result = mysqli_query($conn,$sql)) {
    $message = "DB UPDATED";
}

echo $message;


?>