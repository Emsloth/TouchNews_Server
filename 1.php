<?php

require_once "mailConfig.php";

$host = "ssl://smtp.gmail.com";
$username = from;
$password = password;
$port = "465";

$to      = 'gywjd2918@gmail.com';
$subject = '제목';
$message = '안녕';
$headers = 'From: htolsme@gmail.com' . "\r\n" .
	'host:' . $host . "\r\n" .
	'port:' . $port . "\r\n" .
	'username:' . $username . "\r\n" .
	'password:' . $password . "\r\n" .
    'Reply-To: htolsme@gmail.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers);


print_r(error_get_last());
?>
