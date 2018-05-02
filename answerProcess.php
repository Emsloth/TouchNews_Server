<?php
include './config/db.php';
$value = json_decode(file_get_contents('php://input'), true);
$doing = $value['doing'];

$response = array();


if(isset($doing) && $doing == 'get') {


	$sql = "select * from Question where id = ".$value['id'];
	$res = mysqli_query($conn, $sql);

	$myQuestions = array();

		while($row = mysqli_fetch_array($res)){
          array_push($myQuestions,
        		array('id' =>$row['id'], 'title'=>$row['title'],'created'=>$row['created'],'content'=>$row['content'],'isCompleted'=>$row['isCompleted']
        	));
		}

	$response['myQuestions'] = $myQuestions;

	$sql = "select * from Answer where questionID =".$value['id']." ORDER BY id DESC";
	$res = mysqli_query($conn, $sql);
	
	$answers = array();

	while($row = mysqli_fetch_array($res)){
      array_push($answers,
    	array('id' =>$row['id'], 'created'=>$row['created'],'content'=>$row['content'], 'questionID' => $row['questionID']
    	));
	}

	$response['answers'] = $answers;

	$response['doing'] = $doing;
	$response['target'] = 'answer';

    echo json_encode($response);
 

} else if(isset($_GET['no']) && isset($_POST['content'])) {

	include './fcm.php';

	$sql = "INSERT INTO Answer (questionID, content, userID, created) VALUES(".$_GET['no'].", '".$_POST['content']."', -5, now())";

	if (!mysqli_query($conn, $sql)) {
   		$response['isSuccess'] = 0;
   		return;
	} 

	$sql = "UPDATE Question SET isCompleted = '1' WHERE id = '".$_GET['no']."'";

	if (!mysqli_query($conn, $sql)) {
			$response['isSuccess'] = 0;
   		return;
	} 

	$sql = "SELECT * FROM Users WHERE id ='".$_POST['userID']."'";
	$res = mysqli_query($conn, $sql);
	$row = mysqli_fetch_array($res);
	$token  = $row['token'];

	$pushMessage = "회원님의 문의에 대한 답변이 등록되었습니다";	
	$res = array();
    $res['title'] = "Touch News";
    $res['questionID'] = $_GET['no'];
    $res['is_background'] = FALSE;
    $res['flag'] = 2;
    $res['message'] = $pushMessage;
    $res['created_at'] = date('Y-m-d G:i:s');
	if (isset($token) && isset($pushMessage)) {
		$fields = send($token, $res);		
		$pushStatus = $fields;
	}	

	header('Location: http://emsloth.vps.phps.kr/manage_qa.php?table='.$_GET['table'].'&page='.$_GET['page'].'&no='.$_GET['no']);

}


?>