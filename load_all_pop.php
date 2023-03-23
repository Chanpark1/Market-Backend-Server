<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include("dbconn.php");
$auth = $_POST['authNum'];
$distance = $_POST['distance'];


$sql_co =
"SELECT longitude, latitude
FROM community_post
";

$data = array();

$co_result = mysqli_query($conn, $sql_co);

while($co = mysqli_fetch_assoc($co_result)) {
    $longitude = $co['longitude'];
    $latitude = $co['latitude'];
}

    $sql = 
"SELECT *, (6371
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
ORDER BY hit_num DESC
";

$sql_query = mysqli_query($conn, $sql);

while($row = mysqli_fetch_assoc($sql_query)) {
    $postauth = $row['post_authNum'];

    $sql_image = 
    "SELECT path
    FROM community_img
    WHERE post_authNum = '$postauth'
    Limit 1
    ";

    $result_image = mysqli_query($conn, $sql_image);
    $path = mysqli_fetch_assoc($result_image);

    array_push($data, array(
        'title' => $row['title'],
        'content' => $row['content'],
        'category' => $row['category'],
        'post_authNum' => $row['post_authNum'],
        'area' => $row['area'],
        'like_num' => $row['like_num'],
        'reply_num' => $row['reply_num'],
        'created' => $row['created'],
        'image_path' => $path['path'],
        'authNum' => $row['authNum']
    ));

    $json = json_encode($data,JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE);
}


echo $json;






?>