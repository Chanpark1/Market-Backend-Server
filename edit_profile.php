<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include("dbconn.php");


$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");


header('Content-Type:application/json; charset=utf8');

$authNum = $_POST['authNum'];
$username = $_POST['username'];

$file_path = "./image";

$sql_dup = 
"SELECT idx
FROM User
WHERE userName = '$username'
AND authNum != '$authNum'
";

$result_dup = mysqli_query($conn,$sql_dup);

$datum = mysqli_fetch_array($result_dup);


if(isset($datum['idx'])) {
    $message = "X";
} else {
    $message = "O";

$sql_username = 
"UPDATE User
SET userName = '$username'
WHERE authNum = '$authNum'
";

$result_username = mysqli_query($conn,$sql_username);

if(isset($_FILES['uploaded_file']['name'])) {

    $sql_origin = 
"SELECT userImage_del
FROM User
WHERE authNum = '$authNum'
";

$origin_result = mysqli_query($conn, $sql_origin);

$row = mysqli_fetch_assoc($origin_result);

$origin_path = $row['userImage_del'];

if(isset($origin_path)) {
    unlink($origin_path);
}

    $basename = basename($_FILES['uploaded_file']['name']);
    $file_path = $file_path . $basename;

    if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'],"./image/".$basename)){
        $update_query = 
        "UPDATE User
        SET userImage = 'http://3.36.34.173/image/".$basename."',
        userImage_del = '/var/www/html/image/".$basename."'
        WHERE authNum = '$authNum'
        ";

        if($update_result = mysqli_query($conn,$update_query)) {
            
        };

    };

} else if($_POST['isDeleted'] == "Yes"){
        

        $sql_un = 
        "SELECT userImage_del
        From User
        WHERE authNum = '$authNum'
        ";

        $query = mysqli_query($conn, $sql_un);

        if($unlinking = mysqli_fetch_array($query)) {
            unlink($unlinking['userImage_del']);

            $sql_del =
        "UPDATE User
        SET userImage = NULL,
        userImage_del = NULL
        WHERE authNum = '$authNum'
        ";

        $query_del = mysqli_query($conn,$sql_del);

        }

    }

}



echo $message;


?>