<?php

$value = json_decode(file_get_contents('php://input'), true);
// array for final json respone
$response = array();

if($value['logInType'] == "facebook"){
	if(file_exists('uploads/image/profile/facebook/'.$value['userID'].'.png')){    /*파일 존재하는지 확인*/
	$response['exist'] = 1;
	}else{
	$response['exist'] = 0;
	}

}else if($value['logInType'] == "google"){
	if(file_exists('uploads/image/profile/google/'.$value['userID'].'.png')){    /*파일 존재하는지 확인*/
	$response['exist'] = 1;
	}else{
	$response['exist'] = 0;
	}

}else{
	if(file_exists('uploads/image/profile/'.$value['userID'].'.png')){    /*파일 존재하는지 확인*/
	$response['exist'] = 1;
	}else{
	$response['exist'] = 0;
	}
}



echo json_encode($response);

?>



