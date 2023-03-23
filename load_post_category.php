<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include("dbconn.php");


$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");


header('Content-Type:application/json; charset=utf8');


$category = $_POST['category'];

$sql = 
"SELECT *
FROM post
WHERE category = '$category'
ORDER BY created DESC
";

$result = mysqli_query($conn,$sql);

$data = array();

while($row = mysqli_fetch_assoc($result)) {

    $img_path = $row['post_authNum'];
    $sql_img =
    "SELECT path 
    FROM post_img
    WHERE post_authNum = '$img_path'
    ";
    $result_path = mysqli_query($conn, $sql_img);
    $rows = mysqli_fetch_assoc($result_path);

    array_push($data,
    array(
        'post_authNum' => $row['post_authNum'],
        'title' => $row['title'],
        'price' => $row['price'],
        'description' => $row['description'],
        'Area' => trim($row['Area']),
        'list' => $row['like_num'],
        'chat_num' => $row['chat_num'],
        'hit_num' => $row['hit_num'],
        'status' => $row['status'],
        'trade_lat' => $row['trade_lat'],
        'trade_lng' => $row['trade_lng'],
        'created' => $row['created'],
        'authNum' => $row['authNum'],
        'profile_image'=> $rows['path']
    ));

    $json = json_encode($data, JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE);
}

echo $json;





?>