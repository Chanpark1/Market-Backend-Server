<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include("dbconn.php");


$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");


header('Content-Type:application/json; charset=utf8');

$text = trim($_POST['text']);
$distance = $_POST['distance'];
$authNum = $_POST['authNum'];

$sql_auth =
"SELECT Longitude, Latitude
FROM User
WHERE authNum = '$authNum'
";

$res_auth = mysqli_query($conn, $sql_auth);

$co = mysqli_fetch_assoc($res_auth);

$latitude = $co['Latitude'];
$longitude = $co['Longitude'];

$sql = 
"SELECT *,
(6371
*acos(
    cos(radians($latitude))
    *cos(radians(Latitude))
    *cos(radians(Longitude) - radians($longitude))
    +sin(radians($latitude))
    *sin(radians(Latitude))
    )
    ) 
AS distance
FROM post
WHERE title
LIKE '%$text%'
HAVING distance < '$distance'

";

$data = array();

$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    
    $img_path = $row['post_authNum'];
    $sql_img = 
    "SELECT path
    FROM post_img
    WHERE post_authNum = '$img_path'
    ";

    $result_path = mysqli_query($conn,$sql_img);
    $rows = mysqli_fetch_assoc($result_path);

    array_push($data,
    array(
    'title' => $row['title'],
    'price' => $row['price'],
    'description' => $row['description'],
    'Area' => $row['Area'],
    'like' => $row['like_num'],
    'chat_num' => $row['chat_num'],
    'created' => $row['created'],
    'post_authNum' => $row['post_authNum'],
    'authNum' => $row['authNum'],
    'hit_num' => $row['hit_num'],
    'trade_lat' => $row['trade_lat'],
    'trade_lng' => $row['trade_lng'],
    'status' => $row['status'],
    'profile_image' => $rows['path']
    
    ));
    $json = json_encode($data, JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE);
}
echo $json;



?>