<?php

include("dbconn.php");

header('Content-Type: application/json; charset=utf8');
$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");


$authNum = $_POST['authNum'];

$sql_query = 
"SELECT Area 
FROM User
Where authNum = '$authNum'
";

$result = mysqli_query($conn,$sql_query);

$row =  mysqli_fetch_assoc($result);

$area = $row['Area'];

echo trim($area);


?>