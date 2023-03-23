<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
include("dbconn.php");
$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
header('Content-Type:application/json; charset=utf8');

$post_authNum = $_POST['post_authNum'];
$reply_authNum = $_POST['reply_authNum'];

$sql = 
"SELECT path, content
FROM reply
WHERE post_authNum = '$post_authNum'
AND reply_authNum = '$reply_authNum'
";

$result = mysqli_query($conn, $sql);
$data = array();

while($row = mysqli_fetch_assoc($result)) {
    array_push($data,
    array(
        'content' => $row['content'],
        'image_path' => $row['path']
    ));

    $json = json_encode($data, JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE);
}
echo $json;




?>