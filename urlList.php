<?php
include 'db.php';

$value = json_decode(file_get_contents('php://input'), true);
/*
Select * From A
left JOIN B
ON A.name = B.name
left JOIN C
ON A.name = C.name
*/
$response['userID'] = $value['userID'];
$response['startrow'] = $value['startrow'];
$res = mysqli_query($conn,"select newslist.id, newslist.title, newslist.subtitle, newslist.address, logoimage.filepath, newscategory.name, language.language, newslist.seq  from newslist
left JOIN newscategory
ON newslist.categoryId = newscategory.id
left JOIN logoimage
ON newslist.imageId = logoimage.id
left JOIN language
ON newslist.languageId = language.id order by newslist.id limit ".$value['startrow'].", 11");

$result = array();

while($row = mysqli_fetch_array($res)){
          array_push($result,
        array('id' =>$row['id'], 'title'=>$row['title'],'subtitle'=>$row['subtitle'],'address'=>$row['address'],'filepath'=>$row['filepath'],'name'=>$row['name'],
                'language'=>$row['language'], 'seq'=>$row['seq']

        ));

}
echo json_encode(array("result"=>$result));
echo json_encode($response);
mysqli_close($conn);

?>


