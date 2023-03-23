<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include("dbconn.php");


$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");


header('Content-Type:application/json; charset=utf8');

$post_authNum = $_POST['post_authNum'];

$sql =
"SELECT * 
FROM post
WHERE post_authNum = '$post_authNum'
";

$result = mysqli_query($conn, $sql);

$data = array();

while($row = mysqli_fetch_assoc($result)) {
    $authNum = $row['authNum'];

    $sql_user = 
    "SELECT userName,userImage
    FROM User
    WHERE authNum = '$authNum'
    ";

    $result_user = mysqli_query($conn, $sql_user);
    $rows = mysqli_fetch_assoc($result_user);

    array_push($data,
    array(
        'title' => $row['title'],
        'price' => $row['price'],
        'description' => $row['description'],
        'created' => $row['created'],
        'Area' => $row['Area'],
        'like_num' => $row['like_num'],
        'chat_num' => $row['chat_num'],
        'hit_num' => $row['hit_num'],
        'status' => $row['status'],
        'category' => $row['category'],
        'username' => $rows['userName'],
        'userImage' => $rows['userImage']
    ));

$json = json_encode($data,JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE);
}

echo $json;


?>