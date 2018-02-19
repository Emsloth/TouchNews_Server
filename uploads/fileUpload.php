<?php
include '../db.php'; 

// Path to move uploaded files
$target_path = "/home/touchnews/www/uploads/image/";
$value = json_decode(file_get_contents('php://input'), true);
// array for final json respone
$response = array();

$sql = "INSERT INTO headerimage (filename, filepath, created) VALUES('".$value['file']."', '".$value['email']."', now())";
if (!$result = mysqli_query($conn, $sql)) {
   error_log("failed to insert data", 0);
}

// getting server ip address
$server_ip = gethostbyname(gethostname());
 
// final file url that is being uploaded
$file_upload_url = 'http://' . $server_ip . '/' . $target_path;

$data = $value['file'];
//list($type, $data) = explode(';', $data);
//list(, $data)      = explode(',', $data);

$data=base64_decode($data);
//$data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data));

//if(is_file($data)){
// echo "it is data";
//$log = "isfile : yes";

//}else{
//echo "isn't data";
//$log = "isfile : no";
//}
//$log = "logstart!".$value['email']."basename of data".basename($data);



 ob_start();                    // start buffer capture
    var_dump($value);           // dump the values
    $contents = ob_get_contents(); // put the buffer into a variable
    ob_end_clean();                // end capture
    error_log($contents);        // log contents of the 
//error_log(var_dump($value));
//error_log( print_r( $value, true ));
/* 
if(isset($value['realfile'])){

if(is_file($value['realfile'])){
	$log = "It is file!";
}else{
	$log = "It is not file!";	
}
///home/touchnews/www/uploads/image/'.date('ymdhis').'.png'	 
 $target_path = $target_path . basename($value['realfile']);
 $log = $log.$value['realfile'];
	 if (!move_uploaded_file($value['realfile'], $target_path)) {
        //if(!file_put_contents('/uploads/image.jpeg', $data) {
            // make error flag true

        $log = $log."could not move the file, and the filePath is : ".$target_path;

        }


}
*/

//error_log($log, 0);

if(isset($value['file'])) {
  //  $target_path = $target_path . basename($data);
   	
    // reading other post parameters
    $email = isset($value['email']) ? $value['email'] : '';
    $name = isset($value['name']) ? $value['name'] : '';
   // $target_path = $target_path.$name.".jpeg";

    $response['file'] = basename($data);
    $response['email'] = $email;

    $im = imagecreatefromstring($data); 

if ($im !== false) {
    header('Content-Type: image/png');
    imagepng($im, '/home/touchnews/www/uploads/image/'.date('ymdhis').'.png');
    imagedestroy($im);
}
else {
error_log("FAIL TO MAKE IMAGE FILE", 0);
  
} 
 
 /*
    try {
        // Throws exception incase file is not being moved
        if (!move_uploaded_file($data, $target_path)) {
	//if(!file_put_contents('/uploads/image.jpeg', $data) {
            // make error flag true
	
	$log = $log."could not move the file, and the filePath is : ".$target_path;


            $response['error'] = true;
            $response['message'] = 'Could not move the file!';
        }
 
        // File successfully uploaded
	$log = $log."successfully uploaded and the filePath is : ".$target_path." and emailvalue is : ".$email;

        $response['message'] = 'File uploaded successfully!';
        $response['error'] = false;
        $response['file_path'] = $file_upload_url . basename($data);
    } catch (Exception $e) {
        // Exception occurred. Make error flag true
        $response['error'] = true;
        $response['message'] = $e->getMessage();
    }
} else {
    // File parameter is missing
    $response['error'] = true;
    $response['message'] = 'Not received any file!F';
}
error_log($log, 0);
// Echo final json response to client

*/

} //주석때문에 새로 넣었어
echo json_encode($response);
?>
