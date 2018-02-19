<?php
include 'db.php';
// Path to move uploaded files

$value = json_decode(file_get_contents('php://input'), true);
// array for final json respone
$response = array();
// getting server ip address
$server_ip = gethostbyname(gethostname());
// final file url that is being uploaded




$data = base64_decode($value['file']);
$f = finfo_open();
$mime_type = finfo_buffer($f, $data, FILEINFO_MIME_TYPE);
$response['mime_type'] = $mime_type;

$im = imagecreatefromstring($data);
$logInType = $value['logInType'];

if ($im !== false) {
	$response['notfalse'] = 1;

	if($logInType == "facebook"){
		$target_path = "/home/touchnews/www/uploads/image/profile/facebook/";
		
		if(file_exists('uploads/image/profile/facebook/'.$value['userID'].'.png')){    /*파일 존재하는지 확인*/
			if(unlink('uploads/image/profile/facebook/'.$value['userID'].'.png')){     /*unlink는 파일 삭제*/
				$response['isOnly'] = 1;
			}else{
				$response['isOnly'] = 0;
			}	
		}else{
			$response['isOnly'] = 1;
		}

	}else if($logInType == "google"){
		$target_path = "/home/touchnews/www/uploads/image/profile/google/";

		if(file_exists('uploads/image/profile/google/'.$value['userID'].'.png')){    /*파일 존재하는지 확인*/
			if(unlink('uploads/image/profile/google/'.$value['userID'].'.png')){     /*unlink는 파일 삭제*/
				$response['isOnly'] = 1;
			}else{
				$response['isOnly'] = 0;
			}	
		}else{
			$response['isOnly'] = 1;
		}

	}else if($logInType == "touchnews"){
		$target_path = "/home/touchnews/www/uploads/image/profile/";

		if(file_exists('uploads/image/profile/'.$value['userID'].'.png')){    /*파일 존재하는지 확인*/
			if(unlink('uploads/image/profile/'.$value['userID'].'.png')){     /*unlink는 파일 삭제*/
				$response['isOnly'] = 1;
			}else{
				$response['isOnly'] = 0;
			}	
		}else{
			$response['isOnly'] = 1;
		}
	}

	

	if($response['isOnly'] == 1){
		header('Content-Type: image/png');
		if(imagepng($im, $target_path.$value['userID'].'.png')){
			imagedestroy($im);
			$response['isCreated'] = 1;
		}else{
			imagedestroy($im);
			$response['isCreated'] = 0;
		}

		if($response['isCreated'] == 1){
			
		}
	}

}else{
	$response['notfalse'] = 0;
	$response['isUpdated'] = 0;
	$response['isCreated'] = 0;
}

echo json_encode($response);
?>
    
