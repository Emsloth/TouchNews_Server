<?php

	function send($to, $message) {

        $fields = array(
            'to' => $to,
            'data' => $message,
        );
        return sendPushNotificationToGCM($fields);
    }
	//generic php function to send GCM push notification
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

<?php 
    include 'db.php';

    $sql = "INSERT INTO Answer (questionID, content, userID, created) VALUES('".$_GET['no']."', '".$_POST['content']."', 'webmaster', now())";

	if (!$result = mysqli_query($conn, $sql)) {
	   		$response['isSuccess'] = 0;
	} else {
			$sql = "UPDATE Question SET isCompleted = '1' WHERE id = '".$_GET['no']."'";
			$result = mysqli_query($conn, $sql);
			if (!$result = mysqli_query($conn, $sql)) {
	   			$response['isSuccess'] = 0;
			} else{

				$sql = "SELECT * FROM GCMToken WHERE userID ='".$_POST['userID']."'";
				$result = mysqli_query($conn, $sql);
				$rowTK = mysqli_fetch_assoc($result);

				$gcmRegID  = $rowTK['token'];
				$pushMessage = "회원님의 문의에 대한 답변이 등록되었습니다";	

				$res = array();
		        $res['title'] = "TouchNews";
		        $res['is_background'] = FALSE;
		        $res['flag'] = 2;
		        $res['message'] = $pushMessage;
		        $res['created_at'] = date('Y-m-d G:i:s');


				if (isset($gcmRegID) && isset($pushMessage)) {
					$fields = send($gcmRegID, $res);		
					$pushStatus = $fields;
				}		

			}

	}

	header('Location: http://emsloth.vps.phps.kr/QABoard.php?table='.$_GET['table'].'&page='.$_GET['page'].'&no='.$_GET['no']);

?>
