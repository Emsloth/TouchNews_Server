<?php
include 'db.php';

$value = json_decode(file_get_contents('php://input'), true);
        // array for final json respone
$response = array();

$res = mysqli_query($conn,"select * from Question where userID ='".$value['userID']."' and logInType='".$value['logInType']."' ORDER BY id DESC");


$result = array();

while($row = mysqli_fetch_array($res)){
          array_push($result,
        array('id' =>$row['id'], 'title'=>$row['title'],'created'=>$row['created'],'content'=>$row['content'],'isCompleted'=>$row['isCompleted']
        ));
}

echo json_encode(array("result"=>$result));

?>

