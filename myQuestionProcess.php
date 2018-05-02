<?php
include './config/db.php';
$value = json_decode(file_get_contents('php://input'), true);
$doing = $value['doing'];
$userID = $value['userID'];

$response = array();

if (!isset($userID) || !isset($doing)) {
	$response['invalid'] = 1;
	echo json_encode($response);
	return;
}


switch ($doing) {

	case 'get':
		$sql = "select * from Question where userID =".$value['userID']." ORDER BY id DESC";
		$res = mysqli_query($conn, $sql);
		$myQuestions = array();

		while($row = mysqli_fetch_array($res)){
          array_push($myQuestions,
        		array('id' =>$row['id'], 'title'=>$row['title'],'created'=>$row['created'],'content'=>$row['content'],'isCompleted'=>$row['isCompleted']
        	));
		}

		$response['myQuestions'] = $myQuestions;
		break;

	case 'add':
		$sql = "INSERT INTO Question (title, content, userID, created, isCompleted) 
			VALUES('".$value['title']."', '".$value['content']."', ".$value['userID'].", now(), '0')";

		$response['isSuccess'] = mysqli_query($conn, $sql) ? 1 : 0;
		break;

	case 'delete':
		$sql = "DELETE FROM Question WHERE id=".$value['id'];
		$response['isSuccess'] = mysqli_query($conn, $sql) ? 1 : 0;
		break;
	
}

$response['userID'] = $userID;
$response['doing'] = $doing;
$response['target'] = 'question';
$response['id'] = $value['id'];
$response['position'] = $value['position'];

echo json_encode($response);
?>