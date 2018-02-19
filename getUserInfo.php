<?php
include 'db.php';

$value = json_decode(file_get_contents('php://input'), true);
        // array for final json respone
$response = array();

$result = mysqli_query($conn,"select * from userInfo where userID ='".$value['userID']."'");

$row = mysqli_fetch_assoc($result);
$response['tempID'] = $row['tempID'];
$response['userEmail'] = $row['userEmail'];
$response['lastLogin'] = $row['lastLogin'];
$response['created'] = $row['created'];

echo json_encode($response);

?>


