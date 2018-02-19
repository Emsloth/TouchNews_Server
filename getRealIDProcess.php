<?php
	include 'db.php';

	$value = json_decode(file_get_contents('php://input'), true);
	// array for final json respone
	$response = array();
	

	$tempID = $value['tempID'];
	$response['tempID'] = $tempID;

	$result = mysqli_query($conn,"select * from userInfo where tempID ='".$tempID."'");
	
	
	if(mysqli_num_rows($result) == 0){
		//doesn't exist the realID which matches with tempID
		$response['isSuccess'] = 0;
	}else{
		$row = mysqli_fetch_assoc($result); 

		$response['isSuccess'] = 1;
		$response['realID'] = $row['userID'] ;
		$response['lastLogin'] = $row['lastLogin'] ;
                $response['created'] = $row['created'] ;
                $response['userEmail'] = $row['userEmail'] ;
                

	}

	echo json_encode($response);
?>
