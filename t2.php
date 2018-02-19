<?php
/* 다중 수신자 */
$to  = 'gywjd2918@gmail.com' . ', ' ; // 콤마인 것에 주의.
$to .= 'emsloth@naver.com';

// 제목
$subject = '가입 인증 메일입니다';

// 메세지
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
  <form action="http://emsloth.vps.phps.kr/Auth.php?string='.'123123'.'" method="POST" target="_blank">
    <input type="hidden" value="auth" name="for">
    <input type="submit" value="가입 완료" class="AuthButton">
  </form>

</body>
</html>
';

// HTML 메일을 보내려면, Content-type 헤더를 설정해야 합니다.
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

// 추가 헤더
$headers .= 'To: User <mary@example.com>, Kelly <'.'emsloth@naver.com'.'>' . "\r\n";
$headers .= 'To: User <'.'gywjd2918@gmail.com'.'>, Kelly <kelly@example.com>' . "\r\n";
$headers .= 'From: webmaster <htolsme@gmail.com>' . "\r\n";
$headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
$headers .= 'Bcc: birthdaycheck@example.com' . "\r\n";

// 메일 보내기
mail($to, $subject, $message, $headers);
?>
