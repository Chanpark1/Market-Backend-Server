<?php
header('Content-Type: application/json; charset=utf8');
error_reporting(E_ALL);
ini_set("display_errors", 1);
include("dbconn.php");


$post_auth = $_POST['post_authNum'];


$sql = 
"SELECT title
FROM post
WHERE post_authNum = '$post_auth'
";


$sql_query = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($sql_query);

echo $row['title'];

?>