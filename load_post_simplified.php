<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include("dbconn.php");


$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");


header('Content-Type:application/json; charset=utf8');

$authNum = $_POST['authNum'];
$distance = $_POST['distance'];

$data = array();

$get_wish = 
"SELECT post_authNum
FROM wishlist
WHERE authNum = '$authNum'
";

$get_co = 
"SELECT Longitude, Latitude
FROM User
WHERE authNum = '$authNum'
";

$result_co = mysqli_query($conn,$get_co);

while ($cos = mysqli_fetch_array($result_co)) {
    $latitude = $cos['Latitude'];
    $longitude = $cos['Longitude'];
}

if($result = mysqli_query($conn, $get_wish)) {

    while ($row = mysqli_fetch_array($result)) {

        $post_authNum = $row['post_authNum'];
        $get_all = 
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
        WHERE post_authNum = '$post_authNum'
        HAVING distance < '$distance'
        ORDER BY created DESC
        ";

        if($finally = mysqli_query($conn, $get_all)) {
            while ($rows = mysqli_fetch_assoc($finally)) {

                $sql_img =
                "SELECT path
                FROM post_img
                WHERE post_authNum = '$post_authNum'
                ";

                $result_image = mysqli_query($conn, $sql_img);
                $imgs = mysqli_fetch_assoc($result_image);

                array_push($data,
                array(
                    'title' => $rows['title'],
                    'price' => $rows['price'],
                    'description' => $rows['description'],
                    'Area' => $rows['Area'],
                    'like' => $rows['like_num'],
                    'chat_num' => $rows['chat_num'],
                    'created' => $rows['created'],
                    'status' => $rows['status'],
                    'post_authNum' => $rows['post_authNum'],
                    'authNum' => $rows['authNum'],
                    'hit_num' => $rows['hit_num'],
                    'trade_lat' => $rows['trade_lat'],
                    'trade_lng' => $rows['trade_lng'],
                    'profile_image' => $imgs['path']
                ));
                $json = json_encode($data, JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE);




            }
        };



    }
}

echo $json;


?>