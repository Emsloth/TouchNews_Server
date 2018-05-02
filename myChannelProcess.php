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

	case 'bookmark':
		$sql = "INSERT INTO BMChannel (userID, channelID) VALUES(".$userID.", ".$value['id'].")";
		$response['isSuccess'] = (mysqli_query($conn, $sql) ? 1 : 0);
		break;

	case 'unbookmark':
		$sql = "DELETE FROM BMChannel WHERE userID=".$userID." AND  channelID=".$value['id'];
		$response['isSuccess'] = (mysqli_query($conn, $sql) ? 1 : 0);
		break;

	case 'get':
		$sql = "SELECT BMChannel.channelID, newslist.title, newslist.subtitle, newslist.address, newslist.logo 
		FROM BMChannel 
		LEFT JOIN newslist ON BMChannel.channelID = newslist.id  
		WHERE BMChannel.userID =".$userID." ORDER BY BMChannel.channelID";
		
		$result = mysqli_query($conn, $sql);
		
		$myChannels = array();

		while($row = mysqli_fetch_assoc($result)){
	          array_push($myChannels, 
	          	array('id' =>$row['channelID'], 'title'=>$row['title'],'subtitle'=>$row['subtitle'],'address'=>$row['address'], 'logo'=>$row['logo']));
	    }	
		$response['myChannels'] = $myChannels;
		break;
}

$response['userID'] = $userID;
$response['doing'] = $doing;
$response['target'] = 'channel';
$response['id'] = $value['id'];
$response['position'] = $value['position'];
echo json_encode($response);

?>

