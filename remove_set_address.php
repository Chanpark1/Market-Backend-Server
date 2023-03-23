<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include("dbconn.php");

$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");

$idx = $_POST['idx'];

$sql_query = 
"DELETE FROM set_address
WHERE idx = '$idx'
";

if($result = mysqli_query($conn,$sql_query)) {
    $message = "Data Deleted";
} else {
    $message = "Data Deleted Failed";
}

echo $message;



?>