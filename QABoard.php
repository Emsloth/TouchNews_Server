<!DOCTYPE html>
<html>
<head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- 합쳐지고 최소화된 최신 CSS -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
      <!-- 부가적인 테마 -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">

</head>
<body>
    <div class='container'>

      <?php
        include 'db.php';
        
        $pageitemnum=8;

        if(!isset($_GET['no'])){
             $sql1 = "SELECT * FROM Question";
             $result1 = mysqli_query($conn, $sql1);
             $count =  mysqli_num_rows($result1);
             $a = ceil($count/$pageitemnum);
              if(!isset($_GET['page'])){
                  $page = "1";
              }else if($_GET['page']<=$a){
                  $page = $_GET['page'];
              }else{
                  $page = $a;
              }

              if($page==""||$page==1){
                  $page1 = 0;
              }else{
                  $page1 = ($page-1)*$pageitemnum;
              }

              if(isset($_COOKIE['id'])&&!isset($_COOKIE['table'])&&$_POST['doing']!='tablecheck'){
                  echo "<form method='POST' action='QABoard.php'><input type='hidden' name='table'  value='QABoard'><input type='hidden' name='doing' value='tablecheck'>앞으로 '".$_GET['table']."'으로 바로 접속하기<input type='checkbox' name='tablecheck'>"."일주일 간 보지 않기"."<input type='checkbox' name='noalarm'><input type='submit' value='save'></form>";
              }

              $sql = "SELECT * FROM Question ORDER BY id DESC LIMIT ".$page1.",".$pageitemnum;
              $result = mysqli_query($conn, $sql);
              echo "<br><div class='table table-responsive'><table class = 'table table-hover'>";
              echo "<thead><tr><th>번호</th><th>제목</th><th>작성자</th></tr></thead><tbody>";
              while ($row = mysqli_fetch_assoc($result)) {

                  echo "<tr><td>".$row['id']."</td><td><a class='title' href='http://emsloth.vps.phps.kr/QABoard.php?table=QABoard&page=".$page."&no=".$row['id']."'>".$row['title']."</a></td>"."<td><a class=author href='#'>".$row['userID']."</a></td></tr>";
               }
              echo "</tbody></table></div>";
              $blockitemnum = 4;
              $blocknum = ceil($a/$blockitemnum);
              $block = ceil($page/4);

              echo "<div style='text-align: center;'><ul class='pagination'>";
              if($block!=1&&$blocknum>1){

                  echo "<li style='padding:0';><a href='QABoard.php?table=".$_GET['table']."&page=1'>&laquo;</a></li>";
                  echo "<li><a href='QABoard.php?table=QABoard&page=".($block-1)*$blockitemnum."'>이전</a></li>";
               }
               for($b=$blockitemnum*$block-($blockitemnum-1);$b<=$block*$blockitemnum;$b++){
                  if($b>$a||$b<=0){
                    exit();
                  }
                  if($b!=$page){
                  echo "<li><a href='QABoard.php?table=QABoard&page=".$b."'>".$b."</a></li>";
                  }else{
                    echo "<li class='active'><a>".$b."</a></li>";
                  }
               }
               if($block!=$blocknum){
                 echo "<li><a href='QABoard.php?table=QABoard&page=".($block*$blockitemnum+1)."'>다음</a></li>";
                 echo "<li><a href='QABoard.php?table=QABoard&page=".$a."'>&raquo;</a></li>";
               }
               echo "</ul></div>";
         }else{
            $sql = "SELECT * FROM Question WHERE id='".$_GET['no']."'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
        
            include 'QAPage.php';
         }

      ?>

  </div>
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <!-- <script src="http://localhost/bootstrap-3.3.6-dist/js/bootstrap.min.js"></script> -->
</body>
</html>

