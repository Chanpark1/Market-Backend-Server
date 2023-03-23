<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

    include_once("./con/con.php");
    $title=$_POST['title'];
    $des=$_POST['des'];
    $pk=$_POST['Board_pk'];
    echo $pk;
    $file_path = "./boardImage";
    $count=$_POST['count'];
    $beforeImg=$_POST['beforeImg'];
    $beforeImg=str_replace('[','',$beforeImg);
    // str_replace() 문자열 치환
    $beforeImg=str_replace(']','',$beforeImg);
    $beforeImg_d=explode(",",$beforeImg);
    // explode() 문자열을 분할하여 배열로 저장
    for ($i=0; $i < count($beforeImg_d); $i++) { 
        echo "<br>";
        echo $beforeImg_d[$i];
        echo "<br>";

    }
    $serverBefore=array();
    $count_int=(int)$count;
    $fn =date("ymdHis");
    $date=date("Y-m-d h:i:s");
    $query = "UPDATE board_ask SET title='$title',description='$des' WHERE b_a_pk = '$pk'";
     // 타이틀 글 업데이트.
    $check_query="SELECT * FROM board_img WHERE board_id='$pk'";
    // board 이미지 경로를 가져오는 쿼리
   
    mysqli_query($con,$query);
    // 게시판에 이미지가 있는지 없는지 확인하는 쿼리
    // $check=mysqli_query($con,$check_query);
    // 이미지파일 삭제에 필요한 쿼리 결과
    $result= mysqli_query($con,$check_query);
    if (mysqli_num_rows($result)>0) {
        //db에서 가져온 기존 파일들의 경로가 1개 이상이면
    
        while ($row = mysqli_fetch_assoc($result)){
            // $row로 파일 경로를 모두 담아서
            array_push($serverBefore,$row['img_location']);
            // array_push() => 첫번째 인자에 들어가는 리스트에 두번째 인자에 들어가는 변수를 담아준다.
            // $serverBefore array에 쿼리문의 결과값 경로를 모두 넣어준다.
        } 
        for ($i=0; $i < count($serverBefore); $i++) { 
            echo "이;전에 있던 서버 이미지들<br>";
            echo $serverBefore[$i];
            echo "이;전에 있던 서버 이미지들<br>";
        }



        
        $delAr=array_diff($serverBefore,$beforeImg_d);
        //$delAr = array_diff()로 반환 된 인덱스
        // 기존에 있던 이미지 경로를 배열에 담아놓은 $serverBefore 와 배열로 저장된 $beforeImg_d를 비교하여 없는 값을 가져온다.
        for ($a=0; $a < count($delAr); $a++) { 
            echo "삭제해야할  서버 이미지들<br>";
            $delAr[$a];
            $del_for_query=$delAr[$a];
            // 반환된 $delAr 수 만큼 db에서 삭제하는 쿼리
              $query_imgasdf="DELETE FROM board_img WHERE img_location ='$del_for_query'";
              mysqli_query($con,$query_imgasdf);
            echo "삭제해야할 서버 이미지들<br>";
            $real_del=str_replace('http://3.37.71.224','.',$delAr[$a]);
            // $real_del = 서버 디렉토리의 파일을 삭제하기 위해 경로를 넣어준다.
            echo "삭제해야할 서버 이미지 경로<br>";
            echo $real_del;
            unlink($real_del);
            // $real_del 서버 디렉토리에서 파일 삭제 (unlink)
            echo "삭제해야할 서버 이미지 경로<br>";
        }     
    }
   
    // mysqli_query($con,$query_img);
    for ($b=0; $b < $count_int; $b++) {
        if (isset($_FILES['uploaded_file'.$b])) {
            echo "씨이이발";
            $basename = basename( $_FILES['uploaded_file'.$b]['name']);
            $file_path = $file_path . $basename; 
            move_uploaded_file($_FILES['uploaded_file'.$b]['tmp_name'],"./boardImage/".$fn.$basename);
            $query_addimg="INSERT INTO board_img (img_location, board_id, img_del) VALUES ('http://3.37.71.224/boardImage/".$fn.$basename."',".$pk.",'../boardImage/".$fn.$basename."')";
            mysqli_query($con,$query_addimg);
        }else{
        }
    }
    echo $beforeImg;