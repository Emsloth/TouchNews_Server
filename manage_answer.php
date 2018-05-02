<?php
if($_GET['doing']!="delcon"&&!isset($_POST['doing'])){

	echo "<p>번호 : ".$row['id']."</p><p>제목 : ".$row['title']."</p><p>글쓴이 : ".$row['userID']."</p><p>내용 : ".$row['content']."</p><p>created : ".$row['created']."</p>";
	echo "<form style='display:inline' method='POST' action='answerProcess.php'><input type='hidden' name='table' value='".$_GET['table']."'><input type='hidden' name='page' value='".$_GET['page']."'><input type='hidden' name='no' value='".$_GET['no']."'><input type='hidden' name='doing' value='"."delpost"."'><input type='submit' value='"."삭제"."' class='btn btn-default btn-sm'></form></li>";
	echo "<a href= 'http://emsloth.vps.phps.kr/manage_qa.php?table=".$_GET['table']."&page=".$_GET['page']."'><button type='button'  class='btn btn-default btn-sm'>목록</button></a>";
	echo  "<form style='display:inline' name='commentsection' method='POST' action='answerProcess.php?table=".$_GET['table']."&page=".$_GET['page']."&no=".$_GET['no']."'><br>
			<input type='hidden' name='userID' value='".$row['userID']."'><br>
			<textarea name='content' rows='3' cols='20'></textarea><br>
			<input type='submit' value='등록'><br>
			</form>";
			$sql3 = "SELECT * FROM Answer WHERE questionID='".$_GET['no']."'";
	        $result3 = mysqli_query($conn, $sql3);
	      	while ($row3 = mysqli_fetch_assoc($result3)) {
	      		  echo "<p>".$row3['content']."</p>";
	      	
	      	}
          
}
?>