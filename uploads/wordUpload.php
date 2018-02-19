<?php

include '../db.php';

$value = json_decode(file_get_contents('php://input'), true);
$response = array();
$sql = "INSERT INTO word (userID, word, meaning, datetime) VALUES('".$value['userID']."', '".$value['word']."', '".$value['meaning']."', now())";
if (!$result = mysqli_query($conn, $sql)) {
 
   $response['isSuccess'] = 0;
}else{
   $response['isSuccess'] = 1;
}


echo json_encode($response);


?>
