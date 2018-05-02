<?php

$response = array();

$response['doing'] = "saveProfile";
$response['target'] = basename( $_FILES['upload']['name']);
$dir = './user/profile/';
$file_path =$dir.basename( $_FILES['upload']['name']);
if(move_uploaded_file($_FILES['upload']['tmp_name'], $file_path)) {
    $response['isSuccess'] = 1;
} else{
    $response['isSuccess'] = 0;
}
echo json_encode($response);
?>

