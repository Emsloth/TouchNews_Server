<?php 
    include 'db.php';

    $value = json_decode(file_get_contents('php://input'), true);
	// array for final json respone
	$response = array();
	$response['logInType'] = $value['logInType'];
	$response['userID'] = $value['userID'];
	$response['title'] = $value['title'];

	if(isset($value['userID'])){
		$sql = "INSERT INTO Question (title, content, userID, created, isCompleted, logInType) VALUES('".$value['title']."', '".$value['content']."', '".$value['userID']."', now(), '0', '".$value['logInType']."')";
		if (!$result = mysqli_query($conn, $sql)) {
	   		$response['isSuccess'] = 0;
			$response['error'] = mysqli_error($conn);
		} else {
			$response['isSuccess'] = 1;
		}

	}else{
		$response['isSuccess'] = 0;
	}

	echo json_encode($response);

?>
