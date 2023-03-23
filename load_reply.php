<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
include("dbconn.php");
$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
header('Content-Type:application/json; charset=utf8');

$authNum = $_POST['authNum'];
$post_authNum = $_POST['post_authNum'];

$sql_reply = 
"SELECT * 
FROM reply
WHERE post_authNum = '$post_authNum'
ORDER BY replyIdx DESC
LIMIT 10
";

$result_reply = mysqli_query($conn, $sql_reply);
$data = array();
while($row = mysqli_fetch_assoc($result_reply)) {
    $reply_authNum = $row['authNum'];

    $sql_user = 
    "SELECT * 
    FROM User
    WHERE authNum = '$reply_authNum'
    
    ";

    $result_user = mysqli_query($conn, $sql_user);
    
    while($rows = mysqli_fetch_array($result_user)) {
        
        array_push($data,
    array(
        'replyIdx' => $row['replyIdx'],
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

    }

}

echo $json;

?>