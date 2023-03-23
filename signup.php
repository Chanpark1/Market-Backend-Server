<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include("dbconn.php");

$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");

header('Content-Type: application/json; charset=utf8');

$username = $_POST['username'];
$useremail = $_POST['email'];
$phoneNo = $_POST['phone'];
$area = $_POST['area'];
$longitude = $_POST['longitude'];
$latitude = $_POST['latitude'];

$authNum = rand(1,2147483647);

if(isset($_FILES['uploaded_file']['name'] )) {
    $basename = basename($_FILES['uploaded_file']['name']);
    
    $tmp_file = $_FILES['uploaded_file']['tmp_name']; 
    
    move_uploaded_file($tmp_file,"./image/".$basename);
  
    $sql= "INSERT INTO User(userEmail, userName, userPhoneNo, created, userImage,authNum,Area,Longitude,Latitude,userImage_del)
     VALUES ('{$useremail}','{$username}','{$phoneNo}',NOW(),'http://3.36.34.173/image/".$basename."','{$authNum}','{$area}','{$longitude}','{$latitude}',
     '/var/www/html/image/".$basename."')";
$result_query = mysqli_query($conn,$sql);

} else {

    $sql= "INSERT INTO User(userEmail, userName, userPhoneNo, created,authNum,Area,Longitude,Latitude)
    VALUES ('{$useremail}','{$username}','{$phoneNo}',NOW(),'{$authNum}','{$area}','{$longitude}','{$latitude}')";
$result_query = mysqli_query($conn,$sql);

}

    
$sql_query = 
"SELECT authNum FROM User WHERE userPhoneNo = '$phoneNo'
";

$result = mysqli_query($conn,$sql_query);

$row = mysqli_fetch_array($result);

$idx = $row['authNum'];




echo $idx;

?>
