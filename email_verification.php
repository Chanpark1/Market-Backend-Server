<?php

$timestamp = floor(microtime(true) * 1000);

$toEmail = $_POST['email'];

$accessKey = "2rN4bpqKxMwYgWZHJqfZ";
$secretKey = "H1NjFMfUrZLKiCYKrw4Du4O7gceDyQBjia3NYpan";

$authNum = rand(100000,999999);

$message = "POST";
$message .= " ";
$message .= "/api/v1/mails";
$message .= "\n";
$message .= $timestamp;
$message .= "\n";
$message .= $accessKey;

$dHash = base64_encode(hash_hmac('sha256', $message,$secretKey,true));

$headers = array(
    "Content-Type: application/json;"
    , "x-ncp-apigw-timestamp: " . $timestamp . ""
    , "x-ncp-iam-access-key: " . $accessKey . ""
    , "x-ncp-apigw-signature-v2: " . $dHash . ""
);

$mailContentDataSet["senderAddress"] = "cyoung4462@naver.com";
$mailContentDataSet["serderName"] = "찬영";
$mailContentDataSet["title"] = "이메일 인증번호 입니다.";
$mailContentDataSet["body"] = stripslashes(htmlspecialchars_decode("인증번호 : $authNum"));
$mailContentDataSet["recipients"][] = array(
    "address" => "$toEmail", "name" => "박찬영", "type" => "R"
);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://mail.apigw.ntruss.com/api/v1/mails");
curl_setopt($ch, CURLOPT_HEADER,true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($mailContentDataSet));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

echo json_encode($authNum);






?>