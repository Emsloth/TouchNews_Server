<?php

 $to = "gywjd2918@gmail.com";

 $subject = "가입 인증 메일";

 $msg  = '
<html>
<head>
</head>
<body>
  <form action="http://emsloth.vps.phps.kr/Auth.php?string=123" method="POST" target="_blank">
  	<input type="hidden" value="auth" name="for">
    <input type="submit" value="가입 완료" class="AuthButton">
  </form>
</body>
</html>
';


$headers = "From: webmaster@emsloth.vps.phps.kr\nReply-To: emsloth@naver.com\nContent-Type: text/html; charset=UTF-8";

$result = mail($to, $subject, $msg, $headers);


print_r(error_get_last());
 ?>
