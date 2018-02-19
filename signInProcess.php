<?php
include 'db.php';

$value = json_decode(file_get_contents('php://input'), true);
$response = array();
if($value['logInType'] == "facebook"){
	$sql = "SELECT created FROM facebook WHERE userID = '".$value['userID']."'";
	$result = mysqli_query($conn, $sql);
	if(mysqli_num_rows($result) != 0){
		$response['exist'] = 1;
		$sql = "UPDATE facebook SET lastLogin = now()";
		if(!$result = mysqli_query($conn, $sql)) {
	   		$response['isSuccess'] = 0;
		}else{
			$response['isSuccess'] = 1;
			$sql = "SELECT lastLogin, created FROM facebook WHERE userID = '".$value['userID']."'";
			$result = mysqli_query($conn, $sql);
			if($row = mysqli_fetch_assoc($result)){
				$response['lastLogin'] = $row['lastLogin'];
				$response['created'] = $row['created'];
			}
		}
	}else{
		$response['exist'] = 0;
		$sql = "INSERT INTO facebook (userID, userName, userEmail, created, lastLogin) VALUES ('".$value['userID']."', '".$value['name']."', '".$value['email']."', now(), now())";
		if(!$result = mysqli_query($conn, $sql)) {
	   		$response['isSuccess'] = 0;
		}else{
			$response['isSuccess'] = 1;
			$sql = "SELECT lastLogin, created FROM facebook WHERE userID = '".$value['userID']."'";
			$result = mysqli_query($conn, $sql);
			if($row = mysqli_fetch_assoc($result)){
				$response['lastLogin'] = $row['lastLogin'];
				$response['created'] = $row['created'];
			}
		}
	}	

}else if($value['logInType'] == "google"){
	$sql = "SELECT created FROM google WHERE userID = '".$value['userID']."'";
	$result = mysqli_query($conn, $sql);
	if(mysqli_num_rows($result) != 0){
		$response['exist'] = 1;
		$sql = "UPDATE google SET lastLogin = now()";
		if(!$result = mysqli_query($conn, $sql)) {
	   		$response['isSuccess'] = 0;
		}else{
			$response['isSuccess'] = 1;
			$sql = "SELECT lastLogin, created FROM google WHERE userID = '".$value['userID']."'";
			$result = mysqli_query($conn, $sql);
			if($row = mysqli_fetch_assoc($result)){
				$response['lastLogin'] = $row['lastLogin'];
				$response['created'] = $row['created'];
			}
		}
	}else{
		$response['exist'] = 0;
		$sql = "INSERT INTO google (userID, userName, userEmail, created, lastLogin) VALUES ('".$value['userID']."', '".$value['name']."', '".$value['email']."', now(), now())";
		if(!$result = mysqli_query($conn, $sql)) {
	   		$response['isSuccess'] = 0;
		}else{
			$response['isSuccess'] = 1;
			$sql = "SELECT lastLogin, created FROM google WHERE userID = '".$value['userID']."'";
			$result = mysqli_query($conn, $sql);
			if($row = mysqli_fetch_assoc($result)){
				$response['lastLogin'] = $row['lastLogin'];
				$response['created'] = $row['created'];
			}
		}
	}	
}

echo json_encode($response);

?>
