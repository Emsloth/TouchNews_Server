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

switch($doing) {

	case 'add':
		$sql = "INSERT INTO BMArticle (userID, title, created, url) VALUES(".$userID.", '".$value['title']."', now(), '".$value['url']."')";
		$response['isSuccess'] = (mysqli_query($conn, $sql) ? 1 : 0);
		break;

	case 'delete':
		$sql = "DELETE FROM BMArticle WHERE userID=".$userID." AND id=".$value['id'];
		$response['isSuccess'] = (mysqli_query($conn, $sql) ? 1 : 0);
		break;

	case 'get':
		$sql = "SELECT * FROM BMArticle WHERE userID =".$userID." ORDER BY id DESC";
		$result = mysqli_query($conn, $sql);
		$myArticles = array();
		while($row = mysqli_fetch_assoc($result)){
			$date = date_create($row['created']);
          	array_push($myArticles, 
          		array('id' =>$row['id'], 'title'=>$row['title'],'datetime'=>date_format($date,"y/m/d"),'url'=>$row['url']));}
	    	$response['myArticles'] = $myArticles;
		break;

	case 'update':
		$sql = "UPDATE BMArticle SET title = '".$value['title']."' WHERE id =".$value['id'];
		$response['isSuccess'] = (mysqli_query($conn, $sql) ? 1 : 0);
		$response['title'] = $value['title'];
		break;
}

$response['userID'] = $userID;
$response['doing'] = $doing;
$response['target'] = 'article';
$response['id'] = $value['id'];
$response['position'] = $value['position'];

echo json_encode($response);

?>
