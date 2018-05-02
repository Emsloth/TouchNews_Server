<?php

include 'db.php';
$value = json_decode(file_get_contents('php://input'), true);
$response = array();

/* ob_start();                    // start buffer capture
    var_dump($value);           // dump the values
    $contents = ob_get_contents(); // put the buffer into a variable
    ob_end_clean();                // end capture
    error_log($contents);        // log contents of the
*/
$response['size'] = sizeof($value);
for($i=0; $i<sizeof($value); $i++){
        $idnumber = $i;
        $sql = "DELETE FROM word WHERE id='".$value[$idnumber]."'";
        if (mysqli_query($conn, $sql) !== TRUE) {
            $response['isSuccess'] = 0;
        }else{
            $response['isSuccess'] = 1;
        }

}

echo json_encode($response);

?>


