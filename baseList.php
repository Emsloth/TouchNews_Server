<?php
include './config/db.php';
$value = json_decode(file_get_contents('php://input'), true);
$response = array();

$target = $value['target'];

if ($target == 'channel') {
	$sql = "SELECT * FROM newslist ORDER BY id limit ".$value['startrow'].", ".$value['rownum'];

	$result = mysqli_query($conn, $sql);

	$channels = array();

	while($row = mysqli_fetch_array($result)){
	          array_push($channels,
	        array('id' =>$row['id'], 'title'=>$row['title'],'subtitle'=>$row['subtitle'],'address'=>$row['address'],'logo'=>$row['logo']
	        ));
	}

	$response['channels'] = $channels;
}


echo json_encode($response);
mysqli_close($conn);
?>