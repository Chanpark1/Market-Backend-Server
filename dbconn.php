<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
    
         $host = 'database-1.c0xl7brkp3bu.ap-northeast-2.rds.amazonaws.com';
         $user = 'chanyoung';
         $password = 'cjsend12';
         $db_name = 'market';
    
         $conn = mysqli_connect($host,$user,$password,$db_name);


//  if($conn){
//     echo "Login success";
// }
//     else{
//     echo "Login fail";
// }

?>