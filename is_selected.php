<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

include("dbconn.php");

header('Content-Type: application/json; charset=utf8');

$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");

$username = $_POST['username'];

$sql_query = 
"SELECT selected_address
FROM User
WHERE userName = '$username'
";

$result = mysqli_query($conn,$sql_query);

$row = mysqli_fetch_assoc($result);

echo $row['selected_address'];


?>