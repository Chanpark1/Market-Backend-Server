<?php
header('Content-Type: application/json; charset=utf8');
error_reporting(E_ALL);
ini_set("display_errors", 1);
include("dbconn.php");

$auth = $_POST['to_authNum'];

$sql = 
"SELECT userName
FROM User
WHERE authNum = '$auth'
";

$sql_query = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($sql_query);

echo $row['userName'];

?>