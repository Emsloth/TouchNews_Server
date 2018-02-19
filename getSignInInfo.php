<?php
include 'db.php';

$value = json_decode(file_get_contents('php://input'), true);
        // array for final json respone
$response = array();
$response['userID'] = $value['userID'];
$response['logInType'] = $value['logInType'];
if($value['logInType'] == "facebook"){
	$response['logInType'] = "facebook";
	$sql = "select * from facebook where userID ='".$value['userID']."'";
}else if($value['logInType'] == "google"){
	$response['logInType'] = "google";
	$sql = "select * from google where userID ='".$value['userID']."'";
}

$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($result);
$response['userEmail'] = $row['userEmail'];
$response['userName'] = $row['userName'];
$response['lastLogin'] = $row['lastLogin'];
$response['created'] = $row['created'];

echo json_encode($response);

?>


