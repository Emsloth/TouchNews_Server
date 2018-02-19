<?php
	include 'db.php';
	$value = json_decode(file_get_contents('php://input'), true);
	$response = array();

	$passwordBefore = $value['passwordBefore'];
	$passwordNew = $value['passwordNew'];
	$hash; 
	$result = mysqli_query($conn,"select userPassword from userInfo where userID = '".$value['userID']."'");
	$row = mysqli_fetch_assoc($result);
	$hash = $row['userPassword'];

	if (password_verify($passwordBefore, $hash)) {
         
            $response['isValid'] = 1;
    
            $hash = password_hash($passwordNew, PASSWORD_BCRYPT); 
         
            $sql = "UPDATE userInfo SET userPassword = '".$hash."' WHERE userID = '".$value['userID']."'";
            $result = mysqli_query($conn, $sql);

            if($result){
            	 $response['isSuccess'] = 1;
            }else{
            	 $response['isSuccess'] = 0;
            }
                 
    } else {
        $response['isValid'] = 0;
        $response['isSuccess'] = 0;
    }

	echo json_encode($response);

?>

