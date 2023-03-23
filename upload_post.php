<?php
header('Content-Type: application/json; charset=utf8');
error_reporting(E_ALL);
ini_set("display_errors", 1);
date_default_timezone_set('Asia/Seoul');
include("dbconn.php");


$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");

$authNum = $_POST['authNum'];
$title = $_POST['title'];
$des = $_POST['description'];
$price = $_POST['price'];
$area = $_POST['area'];
$longitude = $_POST['longitude'];
$latitude = $_POST['latitude'];
$count = $_POST['count'];
$count_int = (int)$count;

$tr_lat = $_POST['trade_lat'];
$tr_lng = $_POST['trade_lng'];

$category = $_POST['category'];

$date = date("Y-m-d H:i:s");
$post_authNum = rand(1,2147483647);
$sql_query = 
"INSERT INTO post(authNum,title,price,description,created,Area,Longitude,Latitude,post_authNum,category,trade_lat,trade_lng)
VALUES ('{$authNum}', '{$title}', '{$price}', '{$des}', '{$date}', '{$area}','{$longitude}','{$latitude}','{$post_authNum}','{$category}','{$tr_lat}','{$tr_lng}')
";
if($result_post = mysqli_query($conn,$sql_query)) {

    $message1 = "post input Success";
}


// $image = $_FILES['uploaded_file'];

// $file_name = $image['name'];
// $tmp_name = $image['tmp_name'];


$file_path = "./postImage";

$title = $_POST['title'];
$price = $_POST['price'];
$description = $_POST['description'];
$authNum = $_POST['authNum'];

$fn = date("ymdHis");
if(isset($_FILES['uploaded_file0']['name'])) {
    for($i = 0; $i<$count_int; $i++) {
        $basename = basename($_FILES['uploaded_file'.$i]['name']);
        $file_path = $file_path . $basename;
       if(isset($_FILES['uploaded_file'.$i])) {
        move_uploaded_file($_FILES['uploaded_file'.$i]['tmp_name'],"./postImage/".$fn.$basename);
        $query_img = 
         "INSERT INTO post_img(path,authNum,img_del,post_authNum)
         VALUES ('http://3.36.34.173/postImage/".$fn.$basename."',$authNum,'../postImage/".$fn.$basename."','$post_authNum')
        ";
       }
      
        if($result_img = mysqli_query($conn,$query_img)) {
            $message = "image input Success";
        } else {
            $message = "실패";
        }
        
    }

}
echo $message;


?>
