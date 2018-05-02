<?php
include './config/db.php';
require 'Predis/Autoloader.php';

Predis\Autoloader::register();

$client = new Predis\Client();
$client->set('foo', 'bar');
$value = $client->get('foo');

echo $value;

$response = array();
$sql = "SELECT * FROM word WHERE userID =1 ORDER BY id DESC LIMIT 1, 6";
$result = mysqli_query($conn, $sql);
$myWords = array();
while($row = mysqli_fetch_assoc($result)){
	$date=date_create($row['datetime']);
   	array_push($myWords, 
   		array('id' =>$row['id'], 'word'=>$row['word'],'meaning'=>$row['meaning'],'datetime'=>date_format($date,"y/m/d")));}
$response['myWords'] = $myWords;

echo json_encode($response);

?>

		
