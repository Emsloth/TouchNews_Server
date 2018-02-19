<?php
include 'db.php';

$value = json_decode(file_get_contents('php://input'), true);
$response = array();
if(isset($value['userID'])){
	$sql = "SELECT * FROM google WHERE userID = '".$value['userID']."'";
	$result = mysqli_query($conn, $sql);
	if($row = mysqli_fetch_assoc($result)){
		$response['exist'] = 1;
	}else{
		$response['exist'] = 0;
		$sql = "INSERT INTO google (userID, userName, userEmail) VALUES ('".$value['userID']."', '".$value['name']."', '".$value['email']."')";
		if(!$result = mysqli_query($conn, $sql)) {
	   		$response['isSuccess'] = 0;
		}else{
			$response['isSuccess'] = 1;
		}
	}	
}


echo json_encode($response);

?>
