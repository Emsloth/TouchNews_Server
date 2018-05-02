<?php

include 'db.php';

$value = json_decode(file_get_contents('php://input'), true);
$response = array();


$sql = "INSERT INTO BMChannel (userID, title, subtitle, filePath, logInType, address) VALUES('".$value['userID']."', '".$value['title']."', '".$value['subtitle']."', '".$value['filePath']."', '".$value['logInType'] ."', '".$value['address'] ."')";
if (!$result = mysqli_query($conn, $sql)) {
   	$response['isSuccess'] = 0;
}else{
	$response['isSuccess'] = 1;
}

echo json_encode($response);


?>

