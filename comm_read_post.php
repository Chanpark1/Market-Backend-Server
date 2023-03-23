<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include("dbconn.php");

$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");

header('Content-Type:application/json; charset=utf8');

$post_authNum = $_POST['post_authNum'];
$authNum = $_POST['authNum'];

$sql = 
"SELECT * 
FROM community_post
WHERE post_authNum = '$post_authNum'
";

$result = mysqli_query($conn,$sql);

$data = array();

while($row = mysqli_fetch_assoc($result)) {
    $user_authNum = $row['authNum'];

    $sql_user= 
    "SELECT userName, userImage
    FROM User
    WHERE authNum = '$user_authNum'
    ";

    $result_user = mysqli_query($conn,$sql_user);

    $rows = mysqli_fetch_assoc($result_user);

    $username = $rows['userName'];
    $path = $rows['userImage'];

    array_push($data,
    array(
        'post_authNum' => $row['post_authNum'],
        'title' => $row['title'],
        'category' => $row['category'],
        'content' => $row['content'],
        'area' => $row['area'],
        'hit_num' => $row['hit_num'],
        'like_num' => $row['like_num'],
        'reply_num' => $row['reply_num'],
        'username' => $username,
        'path' => $path
    ));

    $json = json_encode($data, JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE);
}
 echo $json;






?>