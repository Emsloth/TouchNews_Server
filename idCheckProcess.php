<?php
        include 'db.php';

        $value = json_decode(file_get_contents('php://input'), true);
        // array for final json respone
        $response = array();


        $userID = $value['ID'];
        $response['userID'] = $userID;

        $sql = "SELECT * FROM userInfo WHERE userID ='".$userID."'";

        $result = mysqli_query($conn, $sql);

        if($rowcount = mysqli_num_rows($result) == 0){
                // OKAY !

                $sql = "SELECT * FROM preUserInfo WHERE userID ='".$userID."'";

                $result = mysqli_query($conn, $sql);

                if($rowcount = mysqli_num_rows($result) == 0){
                // OKAY !
                        $response['idCheck'] = 1;
                }else{
                        $response['idCheck'] = 0;
                }

//
        }else{
                //when userID is already exists
                $response['idCheck'] = 0;
        }

        echo json_encode($response);

?>

