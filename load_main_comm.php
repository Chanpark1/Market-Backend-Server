<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include("dbconn.php");

$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");

header('Content-Type:application/json; charset=utf8');

$authNum = $_POST['authNum'];
$distance = $_POST['distance'];

$get_co = 
"SELECT Longitude,Latitude
FROM User
WHERE authNum = '$authNum'
";

$query_co = mysqli_query($conn, $get_co);

while($co = mysqli_fetch_assoc($query_co)) {
    $longitude = $co['Longitude'];
    $latitude = $co['Latitude'];
}

$sql = 
"SELECT *,(6371
*acos(
    cos(radians($latitude))
    *cos(radians(Latitude))
    *cos(radians(Longitude) - radians($longitude))
    +sin(radians($latitude))
    *sin(radians(Latitude))
    )
    ) 
AS distance
FROM community_post
HAVING distance < '$distance'
ORDER BY created DESC
";

$sql_query = mysqli_query($conn,$sql);

$data = array();

while($row = mysqli_fetch_assoc($sql_query)) {
    $post_authNum = $row['post_authNum'];
    $sql_img = 
    "SELECT path
    FROM community_img
    WHERE post_authNum = '$post_authNum'
    ";

    $result_path = mysqli_query($conn,$sql_img);
    $rows = mysqli_fetch_assoc($result_path);
    if(isset($rows['path'])) {
        array_push($data,
        array('title' => $row['title'],
        'content' => $row['content'],
        'category' => $row['category'],
        'authNum' => $row['authNum'],
        'post_authNum' => $row['post_authNum'],
        'area' => $row['area'],
        'like_num' => $row['like_num'],
        'reply_num' => $row['reply_num'],
        'created' => $row['created'],
        'image_path' => $rows['path']
        ));
        $json = json_encode($data, JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE);
    } else {
        array_push($data,
        array('title' => $row['title'],
        'content' => $row['content'],
        'category' => $row['category'],
        'authNum' => $row['authNum'],
        'post_authNum' => $row['post_authNum'],
        'area' => $row['area'],
        'like_num' => $row['like_num'],
        'reply_num' => $row['reply_num'],
        'created' => $row['created']
        ));
        $json = json_encode($data, JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE);
    }
    
    
    

} 

echo $json;




?>