<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include("dbconn.php");


$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");


header('Content-Type:application/json; charset=utf8');

$authNum = $_POST['authNum'];

$sql =
"SELECT userName, userImage
FROM User
WHERE authNum = '$authNum'
";

$data = array();

if($result = mysqli_query($conn,$sql)) {

    while($row = mysqli_fetch_array($result)) {
        array_push($data,
        array(
            'username' => $row['userName'],
            'profile_image' => $row['userImage']
        ));
    }
    $json = json_encode($data,JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE);
}

echo $json;


?>