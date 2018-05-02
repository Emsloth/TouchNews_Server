<?php
/*doing에 따라 다르게 저장. doing이 login, signup이냐에 따라.*/
    include 'db.php';

    $value = json_decode(file_get_contents('php://input'), true);
    // array for final json respone
    $response = array();
    $doing = $value['doing'];
    $userID = $value['userID'];
    $token = $value['token'];

    if(!isset($value['userID'])){
        $response['IDInvalid'] = 1;
        $response['isSuccess'] = 0;
    }else{

        if($doing == "login"){  /*db에 없는 토큰이면 insert 해주고 있던 거면 userID와 맞는지 확인하고 종료.*/

            $sql = "SELECT * FROM GCMToken WHERE token = '".$token."'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            if($row['userID'] == $userID){
                $response['isSuccess'] = 1;
            }else{
                //삭제하고 새로 저장.
                $sql = "DELETE FROM GCMToken WHERE token = '".$token."'";
               
                if(!$result = mysqli_query($conn, $sql)){
                     $response['isSuccess'] = 0;
                }else{
                    $sql = "INSERT INTO GCMToken (userID, token) VALUES ('".$userID."', '".$token."')";
                    if(!$result = mysqli_query($conn, $sql)){
                         $response['isSuccess'] = 0;
                    }else{
                         $response['isSuccess'] = 1;
                    }
                }

            }

        }else if($doing == "signup"){
            $sql = "UPDATE preUserInfo SET token = '".$token."' WHERE userID='".$userID."'";
            if(!$result = mysqli_query($conn, $sql)){
                     $response['isSuccess'] = 0;
            }else{
                     $response['isSuccess'] = 1;
            }

        }else{

        }
      
    }
    echo json_encode($response);
?>

