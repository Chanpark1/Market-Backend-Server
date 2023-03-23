<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
date_default_timezone_set('Asia/Seoul');
include("dbconn.php");

$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");

header('Content-Type: application/json; charset=utf8');

$content = $_POST['content'];
$authNum = $_POST['authNum'];
$post_authNum = $_POST['post_authNum'];
$date = date("Y-m-d H:i:s");
$reply_authNum = rand(1,2147483647);

if(isset($_FILES['uploaded_file']['name'])) {
    $basename = basename($_FILES['uploaded_file']['name']);

    $tmp_file = $_FILES['uploaded_file']['tmp_name'];

    move_uploaded_file($tmp_file,"./replyImage/".$basename);

    $sql = 
    "INSERT INTO reply(content,authNum,post_authNum,reply_authNum,path,del_path,created)
    VALUES('$content','$authNum','$post_authNum','$reply_authNum','http://3.36.34.173/replyImage/".$basename."','./replyImage/".$basename."','$date')
    ";

    $result = mysqli_query($conn, $sql); 
} else {
    $sql = 
    "INSERT INTO reply(content,authNum,post_authNum,reply_authNum,created)
    VALUES('$content','$authNum','$post_authNum','$reply_authNum','$date')
    ";

    $result = mysqli_query($conn, $sql);
}

$sql_reply =
"SELECT *
FROM reply
WHERE reply_authNum = '$reply_authNum'
";

$result_reply = mysqli_query($conn, $sql_reply);
$data = array();
while($row = mysqli_fetch_assoc($result_reply)) {
    $sql_user = 
    "SELECT userName,userImage,Area
    FROM User
    WHERE authNum = '$authNum'
    ";
    $result_user = mysqli_query($conn, $sql_user);
    $rows = mysqli_fetch_assoc($result_user);

    array_push($data,
    array(
        'content' => $row['content'],
        'authNum' => $row['authNum'],
        'post_authNum' => $row['post_authNum'],
        'reply_authNum' => $row['reply_authNum'],
        'created' => $row['created'],
        'like_num' => $row['like_num'],
        'image_path' => $row['path'],
        'username' => $rows['userName'],
        'user_path' => $rows['userImage'],
        'area' => $rows['Area']
    ));
    $json = json_encode($data, JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE);

    $sql_update = 
    "UPDATE community_post
    SET reply_num = reply_num + 1
    WHERE post_authNum = '$post_authNum'
    ";

    $result_update = mysqli_query($conn, $sql_update);

}

echo $json;











?>