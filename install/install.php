<?php
if (file_exists("../config/dbcon.php")) {
?>
     <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
     <script>
     alert("이미 설치가 되어 있습니다.");
     location.replace("../index.php");
     </script>
<?
	exit;
}
// 게시판의 최상단 디렉토리가 쓰기가능인지 검사
if (!is_writeable("../..")) {
?>
    <html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title></title>
    </head>
    <script>
        alert("최상위 디렉토리의 퍼미션을 707 이나 777 로 변경하여 주세요.");
    </script>
    <body>
    최상위 디렉토리의 퍼미션을 707 이나 777 로 변경하여 주세요.
    </body>
    </html>
    <?
	exit;
}
// 변수정리
$host = trim($_REQUEST['host']);
$user = trim($_REQUEST['user']);
$pass = trim($_REQUEST['pass']);
$db_name = trim($_REQUEST['db_name']);

$admin_id = trim($_REQUEST['admin_id']);
$admin_name = trim($_REQUEST['admin_name']);
$admin_pass = trim($_REQUEST['admin_pass']);
// 에러시 메세지 내보낼 함수
function echo_message($msg) {
	echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
	echo '<script>';
	echo 'alert("'.$msg.'");';
	echo 'history.back();';
	echo '</script>';
}

// DB 접속
$connect = mysqli_connect($host, $user, $pass);
if (!$connect) {
	echo_message("MySql 호스트명, 사용자ID, 비밀번호를 확인해 주십시오.");
	exit;
}

$select_db = mysqli_select_db($connect, $db_name);
if (!$connect) {
	echo_message("MySql DB명을 확인해 주십시오.");
	exit;
}
// 테이블 만들기
// 회원
$sql = "
DROP TABLE IF EXISTS `bd__member`;
		";
mysqli_query($connect, $sql);
$sql = "
CREATE TABLE IF NOT EXISTS `bd__member` (
  `m_id` varchar(12) NOT NULL COMMENT '아이디',
  `m_name` varchar(30) NOT NULL COMMENT '이름',
  `m_idx` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '순번',
  `m_pass` varchar(300) NOT NULL COMMENT '비밀번호',
  `m_level` tinyint(2) DEFAULT '1' COMMENT '레벨',
  `m_stat` char(1) DEFAULT 'Y' COMMENT '상태',
  `m_regdate` datetime DEFAULT NULL COMMENT '등록일',
  PRIMARY KEY (`m_id`,`m_name`),
  UNIQUE KEY `UIX_bd__member` (`m_idx`,`m_level`,`m_stat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='회원';
		";
$result1 = mysqli_query($connect, $sql);

// 게시판 설정
$sql = "
DROP TABLE IF EXISTS `bd__board_config`;
		";
mysqli_query($connect, $sql);
$sql = "
CREATE TABLE IF NOT EXISTS `bd__board_config` (
  `bc_idx` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '순번',
  `bc_code` varchar(50) NOT NULL COMMENT '게시판코드',
  `bc_name` varchar(50) NOT NULL COMMENT '게시판이름',
  `bc_head_file` varchar(255) NOT NULL COMMENT '윗부분파일',
  `bc_head` text NOT NULL COMMENT '윗부분파일다음내용',
  `bc_tail_file` varchar(255) NOT NULL COMMENT '아랫부분파일',
  `bc_tail` text NOT NULL COMMENT '아랫부분파일위내용',
  `bc_list_level` tinyint(2) NOT NULL DEFAULT '0' COMMENT '목록레벨',
  `bc_read_level` tinyint(2) NOT NULL DEFAULT '0' COMMENT '읽기레벨',
  `bc_write_level` tinyint(2) NOT NULL DEFAULT '0' COMMENT '쓰기레벨',
  `bc_reply_level` tinyint(2) NOT NULL DEFAULT '0' COMMENT '답글레벨',
  `bc_comment_level` tinyint(2) NOT NULL DEFAULT '0' COMMENT '댓글레벨',
  `bc_admin` text NOT NULL COMMENT '게시판관리자',
  `bc_use_file` tinyint(2) NOT NULL DEFAULT '0' COMMENT '파일업로드여부',
  `bc_use_secret` tinyint(2) NOT NULL DEFAULT '0' COMMENT '비밀글여부',
  `bc_use_reply` tinyint(2) NOT NULL DEFAULT '0' COMMENT '답글여부',
  `bc_use_comment` tinyint(2) NOT NULL DEFAULT '0' COMMENT '댓글여부',
  `bc_regdate` datetime DEFAULT NULL COMMENT '게시판생성일',
  `bc_modidate` datetime DEFAULT NULL COMMENT '게시판수정일',
  PRIMARY KEY (`bc_code`),
  UNIQUE KEY `UIX_bd__board_config` (`bc_idx`,`bc_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='게시판설정';
  		";
$result2 = mysqli_query($connect, $sql);

// 게시판 글
$sql = "
DROP TABLE IF EXISTS `bd__board`;
  		";
mysqli_query($connect, $sql);
$sql = "
CREATE TABLE IF NOT EXISTS `bd__board` (
  `b_idx` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '순번',
  `bc_code` varchar(50) NOT NULL COMMENT '게시판코드',
  `b_num` int(11) unsigned NOT NULL COMMENT '글순서번호',
  `b_reply` varchar(3) NOT NULL COMMENT '답글단계및 순서',
  `m_id` varchar(12) DEFAULT NULL COMMENT '아이디',
  `m_name` varchar(30) DEFAULT NULL COMMENT '이름',
  `b_pass` varchar(300) NOT NULL COMMENT '비밀번호',
  `b_title` varchar(255) NOT NULL COMMENT '글제목',
  `b_contents` text NOT NULL COMMENT '글내용',
  `b_is_secret` tinyint(2) NOT NULL DEFAULT '0' COMMENT '비밀글여부',
  `b_notice` tinyint(2) NOT NULL DEFAULT '0' COMMENT '공지여부',
  `b_filename` varchar(255) DEFAULT '' COMMENT '첨부파일이름',
  `b_filesize` int(11) unsigned DEFAULT '0' COMMENT '첨부파일크기',
  `b_cnt` int(11) unsigned DEFAULT '0' COMMENT '조회수',
  `b_regdate` datetime NOT NULL COMMENT '글등록일시',
  PRIMARY KEY (`b_idx`,`bc_code`),
  UNIQUE KEY `UIX_bd__board` (`b_num`,`b_reply`),
  KEY `FK_bd__member_TO_bd__board` (`m_id`,`m_name`),
  KEY `FK_bd__board_config_TO_bd__board` (`bc_code`),
  CONSTRAINT `FK_bd__board_config_TO_bd__board` FOREIGN KEY (`bc_code`) REFERENCES `bd__board_config` (`bc_code`),
  CONSTRAINT `FK_bd__member_TO_bd__board` FOREIGN KEY (`m_id`, `m_name`) REFERENCES `bd__member` (`m_id`, `m_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='게시판글';
  		";
$result3 = mysqli_query($connect, $sql);

// 댓글
$sql = "
DROP TABLE IF EXISTS `bd__comment`;
  		";
mysqli_query($connect, $sql);
$sql = "
CREATE TABLE IF NOT EXISTS `bd__comment` (
  `co_idx` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '순번',
  `b_idx` int(11) unsigned NOT NULL COMMENT '글고유번호',
  `bc_code` varchar(50) NOT NULL COMMENT '게시판코드',
  `m_id` varchar(12) NOT NULL COMMENT '아이디',
  `m_name` varchar(30) NOT NULL COMMENT '이름',
  `co_pass` varchar(300) NOT NULL COMMENT '비밀번호',
  `co_contents` text NOT NULL COMMENT '댓글 내용',
  `co_regdate` datetime NOT NULL COMMENT '작성일시',
  PRIMARY KEY (`co_idx`,`b_idx`,`bc_code`),
  KEY `FK_bd__member_TO_bd__comment` (`m_id`,`m_name`),
  KEY `FK_bd__board_TO_bd__comment` (`b_idx`,`bc_code`),
  CONSTRAINT `FK_bd__board_TO_bd__comment` FOREIGN KEY (`b_idx`, `bc_code`) REFERENCES `bd__board` (`b_idx`, `bc_code`),
  CONSTRAINT `FK_bd__member_TO_bd__comment` FOREIGN KEY (`m_id`, `m_name`) REFERENCES `bd__member` (`m_id`, `m_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='댓글';
  		";
$result4 = mysqli_query($connect, $sql);

// 조회수용 글 읽기 히스토리
$sql = "
DROP TABLE IF EXISTS `bd__view_history`;
  		";
mysqli_query($connect, $sql);
$sql = "
CREATE TABLE IF NOT EXISTS `bd__view_history` (
  `vh_idx` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '순번',
  `b_idx` int(11) unsigned NOT NULL COMMENT '글고유번호',
  `bc_code` varchar(50) NOT NULL COMMENT '게시판코드',
  `m_id` varchar(12) NOT NULL COMMENT '아이디',
  `m_name` varchar(30) NOT NULL COMMENT '이름',
  `vh_ip` varchar(30) NOT NULL COMMENT '읽은이 아이피',
  `vh_regdate` datetime DEFAULT NULL COMMENT '등록일',
  PRIMARY KEY (`vh_idx`,`b_idx`,`bc_code`),
  UNIQUE KEY `UIX_bd__view_history` (`b_idx`),
  KEY `FK_bd__board_TO_bd__view_history` (`b_idx`,`bc_code`),
  KEY `FK_bd__member_TO_bd__view_history` (`m_id`,`m_name`),
  CONSTRAINT `FK_bd__board_TO_bd__view_history` FOREIGN KEY (`b_idx`, `bc_code`) REFERENCES `bd__board` (`b_idx`, `bc_code`),
  CONSTRAINT `FK_bd__member_TO_bd__view_history` FOREIGN KEY (`m_id`, `m_name`) REFERENCES `bd__member` (`m_id`, `m_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='조회수용 글읽기 히스토리';
  		";
$result5 = mysqli_query($connect, $sql);

// 접속카운트
$sql = "
DROP TABLE IF EXISTS `feelmoa_count`;
  		";
mysqli_query($connect, $sql);
$sql = "
CREATE TABLE IF NOT EXISTS `feelmoa_count` (
  `CT_UID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'CT_UID',
  `CT_HIT` int(9) NOT NULL DEFAULT '9' COMMENT 'CT_HIT',
  `CT_DATE` varchar(14) NOT NULL DEFAULT '' COMMENT 'CT_DATE',
  `CT_WEEKDAY` int(1) NOT NULL DEFAULT '0' COMMENT 'CT_WEEKDAY',
  PRIMARY KEY (`CT_UID`),
  UNIQUE KEY `UIX_feelmoa_count` (`CT_DATE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='접속카운트';
  		";
$result6 = mysqli_query($connect, $sql);

// 접속정보
$sql = "
DROP TABLE IF EXISTS `feelmoa_referer`;
		";
mysqli_query($connect, $sql);
$sql = "
CREATE TABLE IF NOT EXISTS `feelmoa_referer` (
  `RF_UID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'RF_UID',
  `RF_IP` varchar(30) NOT NULL DEFAULT '' COMMENT 'RF_IP',
  `RF_ID` varchar(12) NOT NULL DEFAULT '' COMMENT 'RF_ID',
  `RF_REFERER` varchar(100) NOT NULL DEFAULT '' COMMENT 'RF_REFERER',
  `RF_SEARCH` int(2) NOT NULL DEFAULT '0' COMMENT 'RF_SEARCH',
  `RF_KEYWORD` varchar(50) NOT NULL DEFAULT '' COMMENT 'RF_KEYWORD',
  `RF_OS` int(2) NOT NULL DEFAULT '0' COMMENT 'RF_OS',
  `RF_AGENT` int(2) NOT NULL DEFAULT '0' COMMENT 'RF_AGENT',
  `RF_LANG` varchar(20) NOT NULL DEFAULT '' COMMENT 'RF_LANG',
  `RF_ADDR` varchar(100) NOT NULL DEFAULT '' COMMENT 'RF_ADDR',
  `RF_DATE` varchar(14) NOT NULL DEFAULT '' COMMENT 'RF_DATE',
  PRIMARY KEY (`RF_UID`),
  UNIQUE KEY `UIX_feelmoa_referer` (`RF_DATE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='접속정보';
		";
$result7 = mysqli_query($connect, $sql);

// 팝업
$sql = "
DROP TABLE IF EXISTS `popup__tbl`;
  		";
mysqli_query($connect, $sql);
$sql = "
CREATE TABLE IF NOT EXISTS `popup__tbl` (
  `pop_idx` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '순번',
  `pop_display` tinyint(2) DEFAULT NULL COMMENT '형태',
  `pop_type` tinyint(2) DEFAULT NULL COMMENT '타입',
  `pop_start_date` datetime DEFAULT NULL COMMENT '시작일',
  `pop_end_date` datetime DEFAULT NULL COMMENT '종료일',
  `pop_width` varchar(10) DEFAULT NULL COMMENT '가로사이즈',
  `pop_height` varchar(10) DEFAULT NULL COMMENT '세로사이즈',
  `pop_title` varchar(100) DEFAULT NULL COMMENT '타이틀',
  `pop_live` tinyint(2) DEFAULT NULL COMMENT '쿠키설정',
  `pop_link` varchar(255) DEFAULT NULL COMMENT '링크URL',
  `pop_filename` varchar(255) DEFAULT NULL COMMENT '이미지이름',
  `pop_filesize` int(11) unsigned DEFAULT NULL COMMENT '이미지크기',
  `pop_content` text COMMENT '내용',
  `pop_regdate` datetime DEFAULT NULL COMMENT '등록일',
  PRIMARY KEY (`pop_idx`),
  UNIQUE KEY `UIX_popup__tbl` (`pop_start_date`,`pop_end_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='팝업';
  		";
$result8 = mysqli_query($connect, $sql);

// 테이블이 다 만들어졌는지 검사
if(!$result1 || !$result2 || !$result3 || !$result4 || !$result5 || !$result6 || !$result7 || !$result8){
	echo_message("테이블 생성에 실패하였습니다.");
	exit;
}

// 운영자 회원테이블에 입력
$sql = "
insert into bd__member 
  		(m_id, m_name, m_pass, m_level, m_regdate) values 
  		('".$admin_id."', 
  		 '".$admin_name."', 
  		HEX(AES_ENCRYPT('".$admin_pass."', 'thsvlftkdWkd')), 
  		  9,
  		now())
  		";
$result9 = mysqli_query($connect, $sql);
if(!$result9){
	echo_message("운영자 정보를 적는데 실패하였습니다.");
	exit;
}

// DB설정 파일 생성
$file = "../config/dbcon.php";
$fp = fopen($file, "w");
fwrite($fp, "<?\n");
fwrite($fp, "\$mysql_host = '$host';\n");
fwrite($fp, "\$mysql_user = '$user';\n");
fwrite($fp, "\$mysql_password = '$pass';\n");
fwrite($fp, "\$mysql_db = '$db_name';\n");
fwrite($fp, "?>");
fclose($fp);
chmod($file, 0606);
// 첨부파일 저장할 폴더 생성
mkdir("../data", 0707);
chmod("../data", 0707);
?>
<!DOCTYPE html>
<html lang="ko">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 위 3개의 메타 태그는 *반드시* head 태그의 처음에 와야합니다; 어떤 다른 콘텐츠들은 반드시 이 태그들 *다음에* 와야 합니다 -->
    <title>SonBOARD 설치</title>

    <!-- 부트스트랩 -->
    <link href="../skin/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE8 에서 HTML5 요소와 미디어 쿼리를 위한 HTML5 shim 와 Respond.js -->
    <!-- WARNING: Respond.js 는 당신이 file:// 을 통해 페이지를 볼 때는 동작하지 않습니다. -->
    <!--[if lt IE 9]>
      <script src="../skin/bootstrap/js/html5shiv.min.js"></script>
      <script src="../skin/bootstrap/js/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="container">
		<div class="row">
			<div class="col-lg-12" style="padding-top:20px">
				<form class="form-signin" name='MyForm' id='MyForm' method='post' onsubmit='return false;'>
					<div class="panel panel-default">
	  				<!-- Default panel contents -->
	  					<div class="panel-heading">SonBOARD 설치 정보</div>
	  						<div class="panel-body">
	    					<p>설치가 완료되었습니다.</p>
	  					</div>
	
					</div>
					
					<button type="button" onclick="location.href='../index.php';" class="btn btn-primary btn-lg btn-block">시작하기</button>
					
				</form>
			</div>
		</div>
		<div style="margin-top:20px;padding-top:20px;border-top:1px solid silver">
<?include '../include/footer.php';?>
		</div>
	</div>
	
    <!-- jQuery (부트스트랩의 자바스크립트 플러그인을 위해 필요합니다) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- 모든 컴파일된 플러그인을 포함합니다 (아래), 원하지 않는다면 필요한 각각의 파일을 포함하세요 -->
    <script src="../skin/bootstrap/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../skin/bootstrap/js/ie10-viewport-bug-workaround.js"></script>
    <!-- Custom js -->
    <script src="../skin/bootstrap/js/myproject.js"></script>
  </body>
</html>