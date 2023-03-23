<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include("dbconn.php");


$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");


header('Content-Type:application/json; charset=utf8');

$authNum = $_POST['authNum'];

$sql = 
"SELECT *
FROM post
WHERE authNum = '$authNum'
AND status = '판매중'
";

$data = array();

$result = mysqli_query($conn,$sql);

while($row = mysqli_fetch_assoc($result)) {

    $post_authNum = $row['post_authNum'];
    $sql_img =
    "SELECT path
    FROM post_img
    WHERE post_authNum = '$post_authNum'
    ";

    $result_img = mysqli_query($conn, $sql_img);

    $rows = mysqli_fetch_assoc($result_img);

    array_push($data,
    array(
        'title' => $row['title'],
        'price' => $row['price'],
        'description' => $row['description'],
        'Area' => $row['Area'],
        'like' => $row['like_num'],
        'chat_num' => $row['chat_num'],
        'created' => $row['created'],
        'status' => $row['status'],
        'post_authNum' => $row['post_authNum'],
        'authNum' => $row['authNum'],
        'hit_num' => $row['hit_num'],
        'trade_lat' => $row['trade_lat'],
        'trade_lng' => $row['trade_lng'],
        'profile_image' => $rows['path']
    ));

    $json = json_encode($data, JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE);

}

echo $json;


?>