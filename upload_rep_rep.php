<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
include("dbconn.php");
$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
header('Content-Type:application/json; charset=utf8');
date_default_timezone_set('Asia/Seoul');

$authNum = $_POST['authNum'];
$post_authNum = $_POST['post_authNum'];
$reply_authNum = $_POST['reply_authNum'];
$content = $_POST['content'];
$date = date("Y-m-d H:i:s");

if(isset($_FILES['uploaded_file']['name'])) {
    $basename = basename($_FILES['uploaded_file']['name']);

    $tmp_file = $_FILES['uploaded_file']['tmp_name'];

    move_uploaded_file($tmp_file,"./rep_repImage/".$basename);

    $sql = 
    "INSERT INTO reply_reply(reply_authNum, post_authNum, authNum, content,path, del_path, created)
    VALUES('$reply_authNum','$post_authNum','$authNum','$content','http://3.36.34.173/rep_repImage/".$basename."','./rep_repImage/".$basename."','$date')
    ";

    $result = mysqli_query($conn, $sql);
} else  {
    $sql = 
    "INSERT INTO reply_reply(reply_authNum, post_authNum, authNum, content, created)
    VALUES('$reply_authNum','$post_authNum','$authNum','$content','$date')
    ";

    $result = mysqli_query($conn, $sql);
}

$sql_update =
"UPDATE community_post
SET reply_num = reply_num + 1
WHERE post_authNum = '$post_authNum'
";

$result_update = mysqli_query($conn,$sql_update);

$sql_final = 
"SELECT *
FROM reply_reply
WHERE post_authNum = '$post_authNum'
AND reply_authNum = '$reply_authNum' 
ORDER BY created DESC
";

$result_final = mysqli_query($conn, $sql_final);

$data = array();

while($row = mysqli_fetch_assoc($result_final)) {

    $user_authNum = $row['authNum'];

    $sql_user =
    "SELECT userName, userImage, Area
    FROM User
    WHERE authNum = '$user_authNum'
    ";

    $result_user = mysqli_query($conn, $sql_user);

    while($rows = mysqli_fetch_assoc($result_user))

       array_push($data,
       array(
        'replyIdx' => $row['replyIdx'],
        'reply_authNum' => $row['reply_authNum'],
        'post_authNum' => $row['post_authNum'],
        'authNum' => $row['authNum'],
        'content' => $row['content'],
        'image_path' => $row['path'],
        'created' => $row['created'],
        'like_num' => $row['like_num'],
        'username' => $rows['userName'],
        'user_path' => $rows['userImage'],
        'area' => $rows['Area']
       ));

       $json = json_encode($data, JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE);
}

echo $json;





?>