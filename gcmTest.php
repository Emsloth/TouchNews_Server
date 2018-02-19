<?php

	function send($to, $message) {

        $fields = array(
            'to' => $to,
            'data' => $message,
        );
        return sendPushNotificationToGCM($fields);
    }
 
    // Sending message to a topic by topic id
    function sendToTopic($to, $message) {
        $fields = array(
            'to' => '/topics/' . $to,
            'data' => $message,
        );
        return sendPushNotificationToGCM($fields);
    }
 
    // sending push message to multiple users by gcm registration ids
     function sendMultiple($registration_ids, $message) {
        $fields = array(
            'registration_ids' => $registration_ids,
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
	
	//this block is to post message to GCM on-click
	$pushStatus = "";	
	if(!empty($_GET["push"])) {	
		
		$gcmRegID  = "cXHWVwlRXUI:APA91bH207xne5Dj4PI2jAM0DRlPFt05etEHPMc2QCDxLhCbbMjtpX0co7J-Azo-JXAu294Mr_GGbTRqjqSs3ZPAhwn3MVcVUtEu9zQg5lOsgfPrH_9BT7dgSPP0-sftNM7r8g3EE7zl";
		$pushMessage = $_POST["message"];	

		$res = array();
        $res['title'] = "gcmTesting";
        $res['is_background'] = FALSE;
        $res['flag'] = 2;
        $res['message'] = $pushMessage;
        //$data['image'] = '';
        $res['created_at'] = date('Y-m-d G:i:s');


		if (isset($gcmRegID) && isset($pushMessage)) {
			$fields = send($gcmRegID, $res);		
			$pushStatus = $fields;
		}		
	}
	
?>
<html>
    <head>
        <title>Google Cloud Messaging (GCM) Server in PHP</title>
    </head>
	<body>
		<h1>Google Cloud Messaging (GCM) Server in PHP</h1>	
		<form method="post" action="gcmTest.php/?push=1">
			<input type="text" name="regid">				                             
			<div>                                
				<textarea rows="2" name="message" cols="23" placeholder="Message to transmit via GCM"></textarea>
			</div>
			<div><input type="submit"  value="Send Push Notification via GCM" /></div>
		</form>
		<p><h3><?php echo $pushStatus; ?></h3></p>        
    </body>
</html>
