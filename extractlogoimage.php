<?php
include 'db.php';


$res = mysqli_query($conn,"select * from logoimage");

$result = array();

while($row = mysqli_fetch_array($res)){
      array_push($result,
        array('id' =>$row[0], 'filename'=>$row[1],'filepath'=>$row[2],'categoryId'=>$row[3],'created'=>$row[4]

        ));
    }
echo json_encode(array("result"=>$result));

mysqli_close($conn);

?>
