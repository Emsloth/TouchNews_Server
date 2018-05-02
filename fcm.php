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
	include_once dirname(__FILE__) . '/config/fcmConfig.php';
	//Google cloud messaging GCM-API url

    $url = 'https://fcm.googleapis.com/fcm/send';
	// Google Cloud Messaging GCM API Key
    $headers = array(
        'Authorization:key=' .FCM_SERVER_KEY,
        'Content-Type:application/json'
    );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
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