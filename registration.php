<?php
    include './config/db.php';
    $value = json_decode(file_get_contents('php://input'), true);
    // array for final json response
    $response = array();
    $userEmail = $value['userEmail'];
    $token = $value['token'];

    if(!isset($userEmail)) {
        $response['invalid'] = 1;
        echo json_encode($response);
        return;
    }

    $response['invalid'] = 0;

    $sql = "SELECT * FROM Users WHERE userEmail = '".$userEmail."'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    if ($row == null) {
        $sql = "INSERT INTO Users (userEmail, token) VALUES ('".$userEmail."', '".$token."')";
        $result = mysqli_query($conn, $sql);
        $response['isSuccess'] = $result ? 1 : 0;
        $response['id'] = mysqli_insert_id($conn);
    } else {
        $response['id'] = $row['id'];
        if (isset($token)) {
            $sql = "UPDATE Users SET token = '".$token."' WHERE userEmail ='".$userEmail."'";
            $response['isSuccess'] = mysqli_query($conn, $sql) ? 1 : 0;
        } else {
            $response['isSuccess'] = 1;
        }        
    }
 
    echo json_encode($response);

    // if(isset($value['token']) && isset($value['userID'])){
    //     $response['invalid'] = 0;
    //     $sql = "SELECT * FROM GCMToken WHERE token = '".$token."'";
    //     $result = mysqli_query($conn, $sql);
    //     $row = mysqli_fetch_assoc($result);

    //     if ($row == null) {
    //         $sql = "INSERT INTO GCMToken (userID, token) VALUES ('".$userID."', '".$token."')";
    //         if(!$result = mysqli_query($conn, $sql)){
    //              $response['isSuccess'] = 0;
    //         }else{
    //              $response['isSuccess'] = 1;
    //         }
    //     } else if ($row['userID'] == $userID) {
    //         $response['isSuccess'] = 1;
    //     } else if ($row['userID'] != $userID) {
    //         $sql = "UPDATE GCMToken SET userID = '".$userID."' WHERE id='".$row['id']."'";
    //         if(!$result = mysqli_query($conn, $sql)){
    //             $response['isSuccess'] = 0;
    //         } else {
    //             $response['isSuccess'] = 1;
    //         }
    //     }

    // } else {
    //     $response['invalid'] = 1;
    //     $response['isSuccess'] = 0;
    // }
    // $response['comment'] = 'commenting';
    // echo json_encode($response);
?>