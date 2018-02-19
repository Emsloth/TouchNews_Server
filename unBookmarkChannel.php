<?php

include 'db.php';

$value = json_decode(file_get_contents('php://input'), true);
$response = array();
$sql = "DELETE FROM BMChannel WHERE userID='".$value['userID']."' AND title='".$value['title']."' AND logInType = '".$value['logInType']."'";
if (!$result = mysqli_query($conn, $sql)) {
   	$response['isSuccess'] = 0;
}else{
	$response['isSuccess'] = 1;
}

echo json_encode($response);

?>
