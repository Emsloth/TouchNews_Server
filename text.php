<?php

error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED ^ E_STRICT);

//set_include_path("." . PATH_SEPARATOR . ($UserDir = dirname($_SERVER['DOCUMENT_ROOT'])) . "/pear/php" . PATH_SEPARATOR . get_include_path());
require_once "/usr/share/php/Mail.php";
require_once "/usr/share/php/Mail/mime.php";

$host = "ssl://smtp.gmail.com";
$username = "htolsme@gmail.com";
$password = "wcljpednezaoxkhr";
$port = "465";
$to = "gywjd2918@naver.com";
$email_from = "htolsme@gmail.com";
$email_subject = "가입을 축하해용 " ;
$mime_params = array(
  'text_encoding' => '7bit',
  'text_charset'  => 'UTF-8',
  'html_charset'  => 'UTF-8',
  'head_charset'  => 'UTF-8'
);
$html = '
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
  <form action="Auth.php?string='.'dddd'.'">
    <input type="submit" value="가입 완료" style="border:none;
          color:#fff
          background-color:#000;
          text-align: center;">
  </form>

</body>
</html>
';
$email_address = "htolsme@gmail.com";

$message = new Mail_mime();
$message->setTXTBody('textbody');
$message->setHTMLBody($html);
$body = $message->get($mime_params);

$extraheaders = array ('From' => $email_from, 'To' => $to, 'Subject' => $email_subject, 'Reply-To' => $email_address);
//$extraheaders = array ('From' => $email_from, 'Subject' => $email_subject);
$headers = $message->headers($extraheaders);

//$smtp = Mail::factory('smtp', array ('host' => $host, 'port' => $port, 'auth' => true, 'username' => $username, 'password' => $password));
$smtp = Mail::factory('smtp', array ('host' => $host, 'MIME-Version' => '1.0', 'Content-type' => 'text/html; charset=UTF-8', 'port' => $port, 'auth' => true, 'username' => $username, 'password' => $password));
$mail = $smtp->send($to, $headers, $body);

if (PEAR::isError($mail)) {
echo("<p>" . $mail->getMessage() . "</p>");
} else {
echo("<p>Message successfully sent!</p>");
}
?>


