<?php

function generateRandomString($length = 8) {
      $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
      $charactersLength = strlen($characters);
      $randomString = '';
      for ($i = 0; $i < $length; $i++) {
          $randomString .= $characters[rand(0, $charactersLength - 1)];
      }
      return $randomString;
  }

include 'db.php';
$value = json_decode(file_get_contents('php://input'), true);
$response = array();

$randomString = generateRandomString();

$to = "";
$subject = "임시 비밀번호";
$message = '
<html>
<head>
  <style>
      .AuthButton{
          border:none;
          color:#fff
          background-color:#000;
          text-align: center;
      }
      .AuthButton:hover {
        color:#000;
        background-color:#ff9800;}
      .AuthButton:active {
        color:#000;
        background-color:#ff9800;}
  </style>
  <title>임시 비밀번호</title>
</head>
<body>
  <p>임시 비밀번호는 아래와 같습니다. 빠른 시일 내에 비밀번호를 새로 변경해주세요.</p>
  <p style = "background-color:#cccccc;">'.$randomString.'</p>

</body>
</html>
';

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <webmaster@emsloth.vps.phps.kr>' . "\r\n";
$headers .= 'Reply-To: <htolsme@gmail.com>' . "\r\n";
//$headers .= 'Cc: myboss@example.com' . "\r\n";

if(isset($value['userID'])){
  $sql = "SELECT * FROM userInfo WHERE userID = '".$value['userID']."' AND userEmail = '".$value['userEmail']."'";
  $result = mysqli_query($conn, $sql);
	
  if($row = mysqli_fetch_assoc($result)){
    $response['Exist'] = 1;
    $hash = password_hash($randomString, PASSWORD_BCRYPT); 
    $sql = "UPDATE userInfo SET userPassword = '".$hash."' WHERE userID = '".$value['userID']."'";
    $result = mysqli_query($conn, $sql);
    if($result){
     $response['isUpdated'] = 1;
     $to = $value['userEmail'];

      if(mail($to,$subject,$message,$headers)){
        $response['mailed'] = 1;
      }else{
        $response['mailed'] = 0;
      }

    }else{
      $response['isUpdated'] = 0;
    }

  }else{
    $response['Exist'] = 0;
  }
  
}


echo json_encode($response);

?>
