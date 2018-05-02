<?php
include 'db.php';

$value = json_decode(file_get_contents('php://input'), true);
$response = array();
if(isset($value['id'])){
	$sql = "UPDATE word SET word = '".$value['word']."', meaning = '".$value['meaning']."' WHERE id = '".$value['id']."'";
	$result = mysqli_query($conn, $sql);
	if($result){
		$response['isSuccess'] = 1;
	}else{
		$response['isSuccess'] = 0;
	}
}

echo json_encode($response);

?>
