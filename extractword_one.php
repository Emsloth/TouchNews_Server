<?php

include 'db.php';

$value = json_decode(file_get_contents('php://input'), true);

$sql = "select * from word where userID ='".$value['userID']."' ORDER BY id DESC LIMIT 0, 1";
//$sql = "select * from word";
$result = mysqli_query($conn, $sql);

$response = array();
//$response['userID'] = $value['userID'];

while($row = mysqli_fetch_array($result)){
       array_push($response,
        array('id' =>$row['id'], 'word'=>$row['word'],'meaning'=>$row['meaning'],'datetime'=>$row['datetime']

        ));

}


echo json_encode(array("response"=>$response));

?>

