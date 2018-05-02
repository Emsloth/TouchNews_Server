<?php
 //$mailto="받는주소";
 $mailto="gywjd2918@gmail.com";
 $subject="메일";
 $content="보내기";
 $result=mail($mailto, $subject, $content);
 if($result){
  echo "mail success";
  }else  {
  echo "mail fail";
 }
 print_r(error_get_last());

?>
