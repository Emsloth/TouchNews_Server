<?php 
	
	include 'db.php';

    $value = json_decode(file_get_contents('php://input'), true);
    $response = array();
    $response['loginProcess'] = "!";
	$inputID  = $value['ID'];
	$inputPassword = $value['Password'];
	$hash; // received by JSON (method : POST)
    $tempID;
	$result = mysqli_query($conn,"select * from userInfo where userID = '".$inputID."'");
    $response['inputID'] = $inputID;
    if(mysqli_num_rows($result) == 0){
        //id doesn't exist
        $response['isIDExist'] = 0;
        $response['isValid'] = 0;
        $result = mysqli_query($conn,"select * from preUserInfo where userID = '".$inputID."'");
        $row = mysqli_fetch_assoc($result);  
        $hash = $row['userPassword'];
        if (password_verify($inputPassword, $hash)) {
      
            $response['isPre'] = 1;

        }else{
            $response['isPre'] = 0;

        }
    }else{
        //id exist
        $response['isIDExist'] = 1;

///////////////////
        $row = mysqli_fetch_assoc($result);  
        // what if the inputID doesn't exist ? It should be already checked.  

        $hash = $row['userPassword'];

        if (password_verify($inputPassword, $hash)) {
          
            $response['isValid'] = 1;
        
            //create tempID and check if the tempID is unique.  
            while(true){
                $tempID =  uniqid();
                $result = mysqli_query($conn, "select * from userInfo where tempID = '".$tempID."'");
                if(mysqli_num_rows($result) == 0){  
                    break;
                }   
            }
            //insert the tempID to the userInfo table. (UPDATE)

            $sql = "UPDATE userInfo SET tempID = '".$tempID."' , lastLogin = now() WHERE userID = '".$inputID."'";
            
            if(!$result = mysqli_query($conn, $sql)){
                $response['isUpdated'] = 0;
            
            }else {
                $response['isUpdated'] = 1;
                $response['tempID'] = $tempID;
                $sql = "select * from userInfo where userID = '".$inputID."'";
                $result = mysqli_query($conn, $sql);
                 if($row = mysqli_fetch_assoc($result)){
                    $response['userID'] = $inputID;
                    $response['userEmail'] = $row['userEmail'];
                    $response['lastLogin'] = $row['lastLogin'];
                    $response['created'] = $row['created'];
        
                
                 }else{

                 }

            }       

        } else {
            $response['isValid'] = 0;
        
            
        }

    }
	
    echo json_encode($response);

?>
