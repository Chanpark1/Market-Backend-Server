<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

include("dbconn.php");
header('Content-Type: application/json; charset=utf8');

$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");


//HASH MAP
$title = $_POST['title'];
$price = $_POST['price'];
$description = $_POST['description'];
$trade_lat = $_POST['trade_lat'];
$trade_lng = $_POST['trade_lng'];
$category = $_POST['category'];


$post_authNum = $_POST['post_authNum'];
$authNum = $_POST['authNum'];

$deleted = $_POST['deleted_list'];
$deleted = str_replace('[','',$deleted);
$deleted = str_replace(']','',$deleted);
$deleted_list = explode(",", $deleted);


//Date for file name
$fn = date("ymdHis");

//FILE
$file_path = "./postImage";

$added_count = $_POST['added_count'];

$int_added = (int)$added_count;

$deleted_count = $_POST['deleted_count'];

$int_deleted = (int)$deleted_count;

$update_text = 
"UPDATE post 
SET title = '$title', 
price = '$price', 
description = '$description',
category = '$category',
trade_lat = '$trade_lat',
trade_lng = '$trade_lng'
WHERE post_authNum = '$post_authNum'
";

$result_text = mysqli_query($conn, $update_text);

// 추가된 이미지 먼저 서버, DB에 저장
$get_image = 
"SELECT *
FROM post_img
WHERE post_authNum = '$post_authNum'
";

echo "----------";
echo $deleted_list[0];
echo "----------";

$get_image_result = mysqli_query($conn,$get_image);

$origin_array = array();

if(mysqli_num_rows($get_image_result) > 0) {
    
    while($row = mysqli_fetch_assoc($get_image_result)) {
        array_push($origin_array,$row['path']);
    }
    //Trying to access array offset on value of type bool in
    // /var/www/html/edit_post.php on line 87
    
    $delAr = array_diff($origin_array,$deleted_list);
 

for($j = 0; $j < count($origin_array); $j++) {
    echo "이;전에 있던 서버 이미지들<br>";
    echo $origin_array[$j];
    echo "이;전에 있던 서버 이미지들<br>";
}

for($k = 0; $k < count($deleted_list); $k++) {

    // 클라이언트 origin_array에서 삭제하고 남은 인덱스 값.

    echo "이건 deleted list";
    echo $deleted_list[$k];
    echo "이건 deleted list";
}

for($a = 0; $a < count($delAr); $a++) {

    // $origin_array에서 $deleted_list를 뺀 나머지 인덱스 값

   
    // echo 'delAr'.$delAr[$a];
    // ^ 얘도 맞음
    $del_for_query = $delAr[$a];
 // 이 포문이 잘못된듯
    $query_image_delete = 
    "DELETE FROM post_img
    WHERE path = '$del_for_query'
    ";
    mysqli_query($conn,$query_image_delete);
    //  ^여기 str_replace(): Passing null to parameter #3 ($subject) of 
    // type array|string is deprecated in 
    // /var/www/html/edit_post.php on line 103


    $real_del = str_replace('http://3.36.34.173','.',$delAr[$a]);

    // echo "real_del".$real_del;
    unlink($real_del);
}
}


if(isset($_FILES['added_file0']['name'])) {
    for($i = 0; $i < $int_added; $i++) {

        $basename = basename($_FILES['added_file'.$i]['name']);
        $file_path = $file_path . $basename;

        move_uploaded_file($_FILES['added_file'.$i]['tmp_name'],"./postImage/".$fn.$basename);

$added_query = 
"INSERT INTO post_img(path, authNum, img_del,post_authNum)
VALUES('http://3.36.34.173/postImage/".$fn.$basename. "',$authNum, '../postImage/".$fn.$basename."','$post_authNum')
";

if($result_added = mysqli_query($conn,$added_query)) {
    $message = "added image input done";
} else {
    $message = "added image input failed";
}

        
}

}
echo $message;


?>s