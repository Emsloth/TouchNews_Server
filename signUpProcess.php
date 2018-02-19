<?php
	include 'db.php';

	function generateRandomString($length = 10) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}


	$value = json_decode(file_get_contents('php://input'), true);
	// array for final json respone
	$response = array();
	$authToken ="";

	$to = "";
$subject = "가입 인증 메일";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <webmaster@emsloth.vps.phps.kr>' . "\r\n";
$headers .= 'Reply-To: <htolsme@gmail.com>' . "\r\n";
//$headers .= 'Cc: myboss@example.com' . "\r\n";



	$userID = $value['userID'];
	$userPassword = $value['userPassword'];
	$userEmail = $value['userEmail'];
	$to = $userEmail;
	$hash = password_hash($userPassword, PASSWORD_BCRYPT); 
	while (true) {
		$authToken = generateRandomString(20);
		$sql = "SELECT * FROM  preUserInfo WHERE authToken = '".$authToken."'";
		$result = mysqli_query($conn, $sql);
		if(mysqli_num_rows($result) == 0){
			break;
		}
	}
	

	$sql = "INSERT INTO preUserInfo (userID, userPassword, userEmail, created, authToken) 
	VALUES ('".$userID."', '".$hash."', '".$userEmail."', now(), '".$authToken."')";

	if (!$result = mysqli_query($conn, $sql)) {
   		$response['isSuccess'] = 0;
	} else {
		$response['isSuccess'] = 1;
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
				  <form action="http://emsloth.vps.phps.kr/Auth.php?string='.$authToken.'" method="POST" target="_blank">
				  	<input type="hidden" value="auth" name="for">
				    <input type="submit" value="가입 완료" class="AuthButton">
				  </form>

				</body>
				</html>
				';

		mail($to,$subject,$message,$headers);
	}

	echo json_encode($response);

?>

