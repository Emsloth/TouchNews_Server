<?php
	header('Content-type: text/html; charset=utf-8');
	include 'db.php';

	//get 의 문자열 읽어서 
	if($_POST['for'] == 'auth' && isset($_GET['string'])){
		//confirmed 칼럼값 1로 바꾸기
		$sql = "SELECT * FROM preUserInfo WHERE authToken='".$_GET['string']."'";
		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_assoc($result);

		if(!isset($row['id'])){
			$response['isSuccess'] = 0;
			echo "<script>alert('유효하지 않은 정보입니다');</script>";
			echo "<script>window.close();</script>";
		}else{
			$sql = "INSERT INTO userInfo (userID, userPassword, userEmail, created) 
		VALUES ('".$row['userID']."', '".$row['userPassword']."', '".$row['userEmail']."', '".$row['created']."')";
		if (!$result = mysqli_query($conn, $sql)) {
			$response['isSuccess'] = 0;
		} else {
			$sql = "DELETE FROM preUserInfo WHERE authToken='".$_GET['string']."'";
			if (!$result = mysqli_query($conn, $sql)) {
	   			$response['isSuccess'] = 0;
			} else {
				$sql = "INSERT INTO GCMToken (userID, token) 
						VALUES ('".$row['userID']."', '".$row['token']."')";
				if (!$result = mysqli_query($conn, $sql)) {
	   				$response['isSuccess'] = 0;
				} else{
					$gcmRegID  = $row['token'];		
					$pushMessage = "회원 인증이 완료되었습니다.";	
					$res = array();
			        $res['title'] = "TouchNews";
			        $res['is_background'] = FALSE;
			        $res['flag'] = 2;
			        $res['message'] = $pushMessage;
			        //$data['image'] = '';
			        $res['created_at'] = date('Y-m-d G:i:s');

					if (isset($gcmRegID) && isset($pushMessage)) {
						$fields = send($gcmRegID, $res);	
	
					}else{
			
					}

					$response['isSuccess'] = 1;
	
					echo "<script>alert('회원 인증이 완료되었습니다');</script>";
					echo "<script>window.close();</script>";

				}				
	
				
			}
		}

		}


		
	}else{
		echo "<script>alert('유효하지 않은 정보입니다');</script>";
		echo "<script>window.close();</script>";
	}

	function send($to, $message) {

        $fields = array(
            'to' => $to,
            'data' => $message,
        );

        return sendPushNotificationToGCM($fields);
    }

    function sendPushNotificationToGCM($fields) {

   		include_once dirname(__FILE__) . '/gcmConfig.php';
		//Google cloud messaging GCM-API url
        $url = 'https://android.googleapis.com/gcm/send';
		// Google Cloud Messaging GCM API Key
        $headers = array(
            'Authorization: key=' . GOOGLE_API_KEY,
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		//curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0); 
		//Disabling SSL Certificate support temporarly	
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);				
        if ($result === FALSE) {
        
            die('Curl failed: ' . curl_error($ch));
          
        }

        curl_close($ch);
  
        return $result;
    }
 

?>


