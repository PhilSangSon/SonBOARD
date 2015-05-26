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
// 설정변수 초기화
$_cfg = array();

// path 정의
$_cfg['skin_path']     = "/skin/bootstrap/";
$_cfg['admin_path']    = "/admin/";
$_cfg['base_path']     = "/";
// project 관련 정의
$_cfg['SiteTitle']     = "이츠엠 홈빌더 V1.0";
$_cfg['projectName']   = $_cfg['SiteTitle'];
// DB 테이블 정의
$_cfg['member_table'] = "bd__member";
$_cfg['config_table'] = "bd__board_config";
$_cfg['board_table'] = "bd__board";
$_cfg['comment_table'] = "bd__comment";
$_cfg['history_table'] = "bd__view_history";

// db.php 파일 인클루드
include ("./config/dbcon.php");
// 사용자 정의 함수 인클루드
include ("./core/lib.php");

// 세션사용은 위한 초기화
ob_start();
session_start();
define('MAIN_PATH', dirname(__FILE__)."/");
// DB 연결
$connect = sql_connect($mysql_host, $mysql_user, $mysql_password, $mysql_db);

?>