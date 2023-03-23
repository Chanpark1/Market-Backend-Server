<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
include("dbconn.php");
$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
header('Content-Type:application/json; charset=utf8');
date_default_timezone_set('Asia/Seoul');

$my_authNum = $_POST['authNum'];

$sql_against1 = 
"SELECT room_auth, post_authNum, from_auth
FROM chat_room
WHERE to_auth = '$my_authNum'
";

$data = array();
$result_against1 = mysqli_query($conn, $sql_against1);
while($row1 = mysqli_fetch_array($result_against1)) {
    $from_auth = $row1['from_auth'];
    $post_authNum = $row1['post_authNum'];
    $room_auth = $row1['room_auth'];

        $sql_user = 
        "SELECT userName, userImage, Area
        FROM User
        WHERE authNum = '$from_auth'
        ";

        $result_user = mysqli_query($conn, $sql_user);

        $row_user = mysqli_fetch_array($result_user);

        $sql_img = 
        "SELECT path
        FROM post_img
        WHERE post_authNum = '$post_authNum'
        ";

        $result_img = mysqli_query($conn, $sql_img);        
        $row_img = mysqli_fetch_array($result_img);

        $sql_message = 
        "SELECT content
        FROM chat_message
        WHERE room_auth = '$room_auth'
        ORDER BY idx DESC
        LIMIT 1
        ";
        
        $result_message = mysqli_query($conn, $sql_message);

        $row_message = mysqli_fetch_assoc($result_message);

            array_push($data,
            array(
                'username' => $row_user['userName'],
            'profile_image' => $row_user['userImage'],
            'area' => $row_user['Area'],
            'post_image' => $row_img['path'],
            'post_authNum' => $post_authNum,
            'to_auth' => $from_auth,
            'content' => $row_message['content'],
            'room_auth' => $room_auth
            ));
            $json = json_encode($data, JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE);
        
    
}

echo $json;



?>