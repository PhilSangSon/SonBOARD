<?php
/**
 * 설정파일
 * @author 손필상
 * @since 2015-05-22
 */
if (!file_exists("./config/dbcon.php")) {
?>
     <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
     <script>
     alert("설치가 되지 않았습니다.");
     location.replace("./install/index.php");
     </script>
     <?
exit;
}
?>