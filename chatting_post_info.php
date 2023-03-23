<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
include("dbconn.php");
header('Content-Type: application/json; charset=utf8');

$post_authNum = $_POST['post_authNum'];

$sql =
"SELECT title, price, status
FROM post
WHERE post_authNum = '$post_authNum'
";

$result = mysqli_query($conn, $sql);

$data = array();

while($row = mysqli_fetch_assoc($result)) {

    $sql_img = 
    "SELECT path
    FROM post_img
    WHERE post_authNum = '$post_authNum'
    ORDER BY idx DESC
    LIMIT 1
    ";

    $result_img = mysqli_query($conn, $sql_img);

    $rows = mysqli_fetch_assoc($result_img);

    array_push($data, array(
        'title' => $row['title'],
        'price' => $row['price'],
        'status' => $row['status'],
        'postImage' => $rows['path']
    ));

    $json = json_encode($data, JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE);
}

echo $json;



?>