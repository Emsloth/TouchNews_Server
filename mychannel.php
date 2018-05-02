<?php
include 'db.php';

$value = json_decode(file_get_contents('php://input'), true);
        // array for final json respone
$response = array();

$res = mysqli_query($conn,"select * from BMChannel where userID ='".$value['userID']."' and logInType = '".$value['logInType']."' ORDER BY id DESC" );


$result = array();

while($row = mysqli_fetch_assoc($res)){
          array_push($result,
        array('id' =>$row['id'], 'title'=>$row['title'],'subtitle'=>$row['subtitle'],'filePath'=>$row['filePath'], 'address'=>$row['address']
        ));
}

echo json_encode(array("result"=>$result));

?>

