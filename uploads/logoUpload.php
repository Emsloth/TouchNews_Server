<?php
	include '../db.php';
?>
<!DOCTYPE html>
<html>
<head>
     <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
     <link href="http://localhost/bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="http://localhost/css/style.css">
</head>
<body>
 <header>
</header>

<!-- 데이터 인코딩형 enctype은 꼭 아래처럼 설정해야 합니다 -->
<form enctype="multipart/form-data" action="logoUploadProcess.php" method="POST">
    <!-- MAX_FILE_SIZE는 file 입력 필드보다 먼저 나와야 합니다 -->
   <!-- <input type="hidden" name="MAX_FILE_SIZE" value="30000" /> -->
    <!-- input의 name은 $_FILES 배열의 name을 결정합니다 -->
    이 파일을 전송합니다: <input name="userfile" type="file" /><br>
	분류  <select name='category'>
	 <?php 
	 	$result = mysqli_query($conn, "SELECT * FROM newscategory");
 		while( $row = mysqli_fetch_assoc($result)){
          echo "<option value='".$row['id']."'>".$row['name']."</option>";} 
       ?>
	</select><br>
	언어 <select name='language'>
         <?php
                $result = mysqli_query($conn, "SELECT * FROM language");
                while( $row = mysqli_fetch_assoc($result)){
          echo "<option value='".$row['id']."'>".$row['language']."</option>";}
       ?>
        </select><br>


	title  <input type='text' name='title'/><br>
	subtitle  <input type='text' name='subtitle'/><br>
	address <input type='text' name='address'/><br>

    <input type="submit" value="파일 전송" />
</form>



<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="http://localhost/bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
</body>
</html>
