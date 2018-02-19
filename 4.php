<?php
$to = "emsloth@naver.com, gywjd2918@gmail.com";
$subject = "가입 인증 메일";
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
  <title>회원 인증 메일 보내기</title>
</head>
<body>
  <p>아래 버튼을 누르면 회원 가입이 완료됩니다.</p>
  <form action="http://emsloth.vps.phps.kr/Auth.php?string=123123" method="POST" target="_blank">
  	<input type="hidden" value="auth" name="for">
    <input type="submit" value="가입 완료" class="AuthButton">
  </form>

</body>
</html>
';

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <webmaster@emsloth.vps.phps.kr>' . "\r\n";
$headers .= 'Reply-To: <htolsme@gmail.com>' . "\r\n";
$headers .= 'Cc: myboss@example.com' . "\r\n";

$result = mail($to,$subject,$message,$headers);
echo $result;
?>
