<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

include("dbconn.php");
header('Content-Type: application/json; charset=utf8');

$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");

$title = $_POST['title'];
$content = $_POST['content'];
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
$file_path = "./commImage";

//Date for file name
$fn = date("ymdHis");

//FILE
$file_path = "./postImage";

$added_count = $_POST['added_count'];

$int_added = (int)$added_count;

$deleted_count = $_POST['deleted_count'];

$int_deleted = (int)$deleted_count;

$update_text = 
"UPDATE community_post
SET title = '$title',
content = '$content',
category = '$category'
WHERE post_authNum = '$post_authNum'
";

$result_text =  mysqli_query($conn, $update_text);

$get_image =
"SELECT *
FROM community_img
WHERE post_authNum = '$post_authNum'
";

$get_image_result = mysqli_query($conn, $get_image);

$origin_array = array();

if(mysqli_num_rows($get_image_result) > 0) {

    while($row = mysqli_fetch_assoc($get_image_result)) {
        array_push($origin_array,$row['path']);
    }

    $delAr = array_diff($origin_array,$deleted_list);

    for($i = 0; $i < count($delAr); $i++) {
        $del_for_query = $delAr[$i];

        $query_image_delete = 
        "DELETE FROM community_img
        WHERE path = '$del_for_query'
        ";

        mysqli_query($conn, $query_image_delete);

        $real_del = str_replace('http://3.36.34.173','.',$delAr[$i]);

        unlink($real_del);
    }
}

if(isset($_FILES['added_file0']['name'])) {
    for($i = 0; $i < $int_added; $i++) {
        
        $basename = basename($_FILES['added_file'.$i]['name']);
        $file_path = $file_path . $basename;

        move_uploaded_file($_FILES['added_file'.$i]['tmp_name'],"./commImage/".$fn.$basename);

        
        $added_query = 
        "INSERT INTO community_img(path,del_path,authNum,post_authNum)
        VALUES('http://3.36.34.173/commImage/".$fn.$basename."','../commImage/".$fn.$basename."','$authNum','$post_authNum')
        ";

        $result_added = mysqli_query($conn,$added_query);
    }
}


?>