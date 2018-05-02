<?php

include 'db.php';
$value = json_decode(file_get_contents('php://input'), true);

$response = array();
$userID;
$to = "";
$subject = "아이디";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <webmaster@emsloth.vps.phps.kr>' . "\r\n";
$headers .= 'Reply-To: <htolsme@gmail.com>' . "\r\n";
//$headers .= 'Cc: myboss@example.com' . "\r\n";

if(isset($value['userEmail'])){
  $sql = "SELECT * FROM userInfo WHERE userEmail = '".$value['userEmail']."'";
  $result = mysqli_query($conn, $sql);
  if($row = mysqli_fetch_assoc($result)){
    $response['exist'] = 1;
    $to = $value['userEmail'];
    $userID = $row['userID'];
    $response['userID'] = $userID;
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
      <title>아이디</title>
    </head>
    <body>
      <p>회원님의 아이디는 아래와 같습니다.</p>
      <p style = "background-color:#cccccc;">'.$userID.'</p>

    </body>
    </html>
    ';

    if(mail($to,$subject,$message,$headers)){
        $response['mailed'] = 1;
      }else{
        $response['mailed'] = 0;
      }

  }else{
    //db에 입력한 이메일 없는 것
    $response['exist'] = 0;
  }
}


echo json_encode($response);
?>


