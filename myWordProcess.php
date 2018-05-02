<?php
include './config/db.php';
$value = json_decode(file_get_contents('php://input'), true);
$doing = $value['doing'];
$userID = $value['userID'];

$response = array();

if (!isset($doing)) {
	$response['invalid'] = 1;
	echo json_encode($response);
	return;
}

$response['invalid'] = 0;

switch ($doing) {

	case 'add':
		$sql = "INSERT INTO word (userID, word, meaning, datetime) VALUES('".$userID."', '".$value['word']."', '".$value['meaning']."', now())";
		$result = mysqli_query($conn, $sql);
		$insert_id = mysqli_insert_id($conn);
		$response['isSuccess'] = ($result ? 1 : 0);

		$myWords = array();

		$sql = "SELECT * FROM word WHERE id =".$insert_id;
		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_assoc($result);

		if ($row != null) {
			array_push($myWords, 
	       		array('id' =>$row['id'], 'word'=>$row['word'],'meaning'=>$row['meaning'],'datetime'=>$row['datetime']));
			$response['myWords'] = $myWords;
		}
		break;

	case 'delete':
		$receivedArray = $value['words'];
		$deletedWords = array();
		$num = 0;
		for($i=0; $i < sizeof($receivedArray); $i++) {
	    	$sql = "DELETE FROM word WHERE id ='".$receivedArray['mValues'][$i]."'";
	    	$result = mysqli_query($conn, $sql);
	        if ($result) array_push($deletedWords, $receivedArray['mKeys'][$i]);
		}
		$response['sparseArray'] = $receivedArray;

		$response['isSuccess'] = (sizeof($receivedArray) == sizeof($deletedWords)) ? 1 : 0;
		$response['deletedWordPositions'] = $deletedWords;

		break;

	case 'get':
		$sql = "SELECT * FROM word WHERE userID ='".$userID."' ORDER BY id DESC LIMIT ".$value['startrow'].", ".$value['rownum'];
		$result = mysqli_query($conn, $sql);
		$myWords = array();
		while($row = mysqli_fetch_assoc($result)){
			$date=date_create($row['datetime']);
	       	array_push($myWords, 
	       		array('id' =>$row['id'], 'word'=>$row['word'],'meaning'=>$row['meaning'],'datetime'=>date_format($date,"y/m/d")));}
	    $response['myWords'] = $myWords;
		break;

	case 'update':
		$sql = "UPDATE word SET word = '".$value['word']."', meaning = '".$value['meaning']."' WHERE id = '".$value['id']."'";
		$response['isSuccess'] = (mysqli_query($conn, $sql) ? 1 : 0);
		$response['word'] = $value['word'];
		$response['meaning'] = $value['meaning'];
		break;
}

$response['userID'] = $userID;
$response['doing'] = $doing;
$response['target'] = 'word';
$response['id'] = $value['id'];
$response['position'] = $value['position'];

echo json_encode($response);

?>
