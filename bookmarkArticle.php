<?php

include 'db.php';

$value = json_decode(file_get_contents('php://input'), true);
$response = array();
if(isset($value['userID'])){
	$sql = "INSERT INTO BMArticle (userID, title, created, url, logInType) VALUES('".$value['userID']."', '".$value['title']."', '".$value['datetime']."', '".$value['url']."' , '".$value['logInType'] ."')";
	if (!$result = mysqli_query($conn, $sql)) {
	   	$response['isSuccess'] = 0;
	}else{
		$response['isSuccess'] = 1;
	}
}else{
		$response['isSuccess'] = 0;
}

echo json_encode($response);


?>

