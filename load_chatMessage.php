<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
include("dbconn.php");
$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
header('Content-Type:application/json; charset=utf8');

$from_authNum = $_POST['from_auth'];
$to_authNum = $_POST['to_auth'];
$room_auth = $_POST['room_auth'];
$post_auth = $_POST['post_authNum'];
$sql_all = 
"SELECT *
FROM chat_message
WHERE room_auth = '$room_auth'
AND post_auth = '$post_auth'
ORDER BY idx DESC
LIMIT 10
";
$data = array();


$result_all = mysqli_query($conn, $sql_all);

while($row = mysqli_fetch_assoc($result_all)) {
    
    if($row['to_auth'] == $to_authNum) {
        $view = 0;
    } else {
        $view = 1;
    }

    $sql_user = 
    "SELECT userImage
    FROM User
    WHERE authNum = '$to_authNum'
    ";

    $result_user = mysqli_query($conn, $sql_user);

    $img = mysqli_fetch_array($result_user);

    array_push($data,
    array(
        'idx' => $row['idx'],
        'to_auth' => $row['to_auth'],
        'from_auth' => $row['from_auth'],
        'created' => $row['created'],
        'content' => $row['content'],
        'userImage' => $img['userImage'],
        'ViewType' => $view
    ));

    $json = json_encode($data, JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE);
}

echo $json;



// while($user = mysqli_fetch_array($result_user)) {
//     $userImage = $user['userImage'];

//     $sql_content_from = 
//     "SELECT * 
//     FROM chat_message
//     WHERE room_auth = '$room_auth'
//     AND from_auth = '$from_authNum'
//     ";

//     $result_content_from = mysqli_query($conn, $sql_content_from);
//     $from = mysqli_fetch_assoc($result_content_from);

//     $sql_content_to = 
//     "SELECT * 
//     FROM chat_message
//     WHERE room_auth = '$room_auth'
//     AND from_auth = '$to_authNum'
//     ";
//     $result_content_to = mysqli_query($conn,$sql_content_to);
//     while($row_from = mysqli_fetch_assoc($result_content_from)) {
//     while($row_to = mysqli_fetch_assoc($result_content_to)) {
        
//             array_push($data,
//             array(
//                 'to_idx' => $row_to['idx'],
//                 'from_idx' => $row_from['idx'],
//                 'from_auth' => $row_to['from_auth'],
//                 'to_auth' => $row_to['to_auth'],
//                 'to_created' => $row_to['created'],
//                 'to_content' => $row_to['content'],
//                 'to_userImage' => $userImage,
//                 'from_created' => $row_from['created'],
//                 'from_content' => $row_from['content']
//             ));      
        
//             $json = json_encode($data, JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE); 
//         }   
//     }
  
// }

// echo $json;
?>