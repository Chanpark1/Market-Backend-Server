<?php
    // include("dbconn.php");
 
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
   
    $phoneNum = $_POST['phone'];

    $sID = "ncp:sms:kr:298469624143:market";
    $smsURL = "https://sens.apigw.ntruss.com/sms/v2/services/".$sID."/messages";
    $smsUri = "/sms/v2/services/".$sID."/messages";

    $accKeyId = "2rN4bpqKxMwYgWZHJqfZ";
    $accSecKey = "H1NjFMfUrZLKiCYKrw4Du4O7gceDyQBjia3NYpan";

    $sTime = floor(microtime(true) * 1000);

    $authNum = rand(100000,999999);


    $postData = array(
        'type' => 'SMS',
        'countryCode' => '82',
        'from' => '01023812539',
        'contentType' => 'COMM',
        'content'=> $authNum,
        'messages' => array(array('content' => "인증번호 : ".$authNum,'to' => $phoneNum))
    );

    $postFields = json_encode($postData);

    $hashString = "POST {$smsUri}\n{$sTime}\n{$accKeyId}";

    $dHash = base64_encode(hash_hmac('sha256',$hashString,$accSecKey,true));

    $header = array(
        'Content-Type: application/json; charset=utf-8',
        'x-ncp-apigw-timestamp: '.$sTime,
        "x-ncp-iam-access-key: ".$accKeyId,
        "x-ncp-apigw-signature-v2: ".$dHash
    );

    $ch = curl_init($smsURL);

    curl_setopt_array($ch,array(
        CURLOPT_POST => TRUE,
        CURLOPT_RETURNTRANSFER => TRUE,
        CURLOPT_HTTPHEADER => $header,
        CURLOPT_POSTFIELDS => $postFields
    ));

    $response = curl_exec($ch);

    curl_close($ch);

    echo json_encode($authNum);




   
?>
