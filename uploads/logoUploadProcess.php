<?php
// 4.1.0 이전의 PHP에서는, $_FILES 대신에 $HTTP_POST_FILES를
// 사용해야 합니다.
include '../db.php';
$title = preg_replace("/\s+/", "", $_POST['title']);
$filename = $title.".".pathinfo($_FILES['userfile']['name'], PATHINFO_EXTENSION);

$uploaddir = '/home/touchnews/www/uploads/image/logo/';
//$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
$uploadfile = $uploaddir .$filename;
$imageurl = 'http://emsloth.vps.phps.kr/uploads/image/logo/'.$filename;
$sql = "SELECT * FROM newslist WHERE title = '".$_POST['title']."'";
$result = mysqli_query($conn, $sql);
if($rowcount = mysqli_num_rows($result)!=0){
	echo "The title already exists.";
}else{

echo '<pre>';
if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
    echo "Success\n";	
$sql = "INSERT INTO logoimage (filename, filepath, categoryId, created) VALUES('".$filename."', '".$imageurl."', '".$_POST['category']."', now())";
if (!$result = mysqli_query($conn, $sql)) {
   echo "failed to insert data";
}
$sql = "SELECT * FROM logoimage WHERE filename ='".$filename."'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

$sql = "SELECT * FROM newslist";
$result = mysqli_query($conn, $sql);
$rowcount=mysqli_num_rows($result);

error_log($rowcount."and".$row['filepath'], 0);
$sql = "INSERT INTO newslist(title, subtitle, categoryId, imageId, languageId, seq, address) VALUES('".$_POST['title']."', '".$_POST['subtitle']."', '".$_POST['category']."','".$row['id']."','".$_POST['language']."', '".$rowcount."','".$_POST['address']."')";
if (!$result = mysqli_query($conn, $sql)) {
   error_log("newslist : fail", 0);
}

} else {
    print "FAIL\n";
}
}


echo 'Debugging Info:';
print_r($_FILES);

print "</pre>";

?>
