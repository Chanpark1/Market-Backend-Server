<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
date_default_timezone_set('Asia/Seoul');
include("dbconn.php");


$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");


header('Content-Type:application/json; charset=utf8');


$authNum = $_POST['authNum'];
$title = $_POST['title'];
$content = $_POST['content'];
$category = $_POST['category'];
$count = $_POST['count'];
$count_int = (int)$count;
$post_authNum = rand(0,2147483647);
$date = date("Y-m-d H:i:s");

$file_path = "./commImage";

$get_co = 
"SELECT Area,Latitude, Longitude
FROM User
WHERE authNum = '$authNum'
";

$result_co = mysqli_query($conn,$get_co);
if($cos = mysqli_fetch_assoc($result_co)) {
    $area = $cos['Area'];
    $latitude = $cos['Latitude'];
    $longitude = $cos['Longitude'];
 };

 $sql_insert =
 "INSERT INTO community_post(title,content,category,post_authNum,authNum,area,longitude,latitude,created)
 VALUES('{$title}','{$content}','{$category}','{$post_authNum}','{$authNum}','{$area}','$longitude','$latitude','$date')
 ";

 $result = mysqli_query($conn,$sql_insert);

 $fn = date("ymdHis");

 if(isset($_FILES['uploaded_file0']['name'])) {
    for($i = 0; $i < $count_int; $i++) {
        $basename = basename($_FILES['uploaded_file'.$i]['name']);
        $file_path = $file_path.$basename;

        if(isset($_FILES['uploaded_file'.$i])) {
            move_uploaded_file($_FILES['uploaded_file'.$i]['tmp_name'],"./commImage/".$fn.$basename);

            $query_img = 
            "INSERT INTO community_img(path,del_path,authNum,post_authNum)
            VALUES ('http://3.36.34.173/commImage/".$fn.$basename."','../commImage/".$fn.$basename."','$authNum','$post_authNum') 
            ";

            if($result_img = mysqli_query($conn,$query_img)) {
                $message = "송공";
            } else {
                $message = "실패";
            }
        }


    }
 }

 echo $post_authNum;

?>