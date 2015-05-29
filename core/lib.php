<?php
/**
 * DB 접속 및 데이터 베이스 선택 사용자 함수
 * @param String   $db_host
 * @param String   $db_user
 * @param String   $db_pass
 * @param String   $db_name
 * @return resource
 */
function sql_connect($db_host, $db_user, $db_pass, $db_name) {
	$result = mysqli_connect($db_host, $db_user, $db_pass) or die(mysqli_error());
	mysqli_select_db($result, $db_name) or die(mysqli_error($result));
	
	mysqli_query($result, "set session character_set_connection=utf8;");
	mysqli_query($result, "set session character_set_results=utf8;");
	mysqli_query($result, "set session character_set_client=utf8;");
	
	return $result;
}

/**
 * 쿼리 함수
 * @param String $sql
 * @return $result
 */
function sql_query($sql) {
	global $connect;
	$result = mysqli_query($connect, $sql) or die("<p>$sql<p>".mysqli_errno($connect)." : ".mysqli_error($connect)."<p>error file : $_SERVER[PHP_SELF]");
	return $result;
}

/**
 * 갯수 구하는 함수
 * @param String $sql
 * @return $total_count
 */
function sql_total($sql) {
	global $connect;
	$result_total = sql_query($sql, $connect);
	$data_total = mysqli_fetch_array($result_total);
	$total_count = $data_total['cnt'];
	return $total_count;
}

/**
 * 쿼리를 실행한 후 결과값에서 한행을 구하는 함수
 * @param String $sql
 * @param String $error
 * @return $row
 */
function sql_fetch($sql, $error = TRUE) {
	$result = sql_query($sql, $error);
	$row = mysqli_fetch_array($result);
	return $row;
}

/**
 * 쿼리를 실행 한 후 결과값의 목록을 배열로 구하는 함수
 * @param String $sql
 * @return multitype:$sql_list
 */
function sql_list($sql) {
	$sql_q = sql_query($sql);
	$sql_list = array();
	while ($sql_r = mysqli_fetch_array($sql_q)) {
		$sql_list[] = $sql_r;
	}

	return $sql_list;
}

/**
 * 회원정보 구하는 함수
 * @param String $user_id
 * @return $row
 */
function get_member($user_id) {
	global $_cfg;
	$member = sql_fetch("select * from ".$_cfg[member_table]." where m_id = '".$user_id."'");
	return $member;
}

/**
 * 경고창 띄우고 이동시키는 함수
 * @param String $msg
 * @param String $url
 */
function alert($msg = '', $url = '') {
	if (!$msg)
		$msg = '올바른 방법으로 이용해 주십시오.';
	echo "<script type='text/javascript'>alert('$msg');";
	echo "</script>";
	if ($url) {
		goto_url($url);
	} else {
		echo "<script type='text/javascript'>history.back();";
		echo "</script>";
	}
	exit;
}
/**
 * 경고창 페이지 이동
 * @param string $msg
 * @param string $section
 * @param string $nowpage
 * @param string $page
 */
function PageAlert($msg = '', $section = '', $nowpage = '', $page = '1'){
	if ($msg != ''){
		//$msg = '올바른 방법으로 이용해 주십시오.';
	echo "<script type='text/javascript'>alert('$msg');";
	echo "</script>";
	}
	if ($section != '' && $nowpage != '') {
		echo "
			<form name='PageForm' id='PageForm' method='post' onsubmit='return false;'>
		    	<input type='hidden' name='section' id='section' value='$section'/>
		    	<input type='hidden' name='nowpage' id='nowpage' value='$nowpage'/>
		    	<input type='hidden' name='page' id='page' value='$page'/>
		    </form>
		    <script type='text/javascript'>
		    document.PageForm.submit();
		    </script>
				";
	} else {
		echo "<script type='text/javascript'>history.back();";
		echo "</script>";
	}
	exit;
}

/**
 * 페이지 이동시키는 함수
 * @param String $url
 */
function goto_url($url) {
	echo "<script type='text/javascript'> location.replace('$url'); </script>";
	exit;
}

/**
 * 파일 읽어서 변수로 내용 저장하기
 * @param String $file
 * @return string
 */
function file_read($file) {
	$handle = fopen($file, "r");
	$contents = fread($handle, filesize($file));
	fclose($handle);
	return $contents;
}

/**
 * 접근 권한 체크하는 함수 $this_level = 허용레벨
 * @param int $this_level
 * @return boolean
 */
function check_level($this_level) {
	if ($_SERVER[user_level] >= $this_level) {
		$result = true;
	} else {
		$result = false;
	}
	return $result;
}

/**
 * 페이징 사용자 함수
 * @param int $page
 * @param int $page_row
 * @param int $page_scale
 * @param int $total_count
 * @param string $section
 * @param string $nowpage
 * @param string $ext
 * @return string
 */
function paging($page='1', $page_row, $page_scale, $total_count, $section='', $nowpage='', $ext = '') {
	// 1. 전체 페이지 계산
	$total_page = ceil($total_count / $page_row);

	// 2. 페이징을 출력할 변수 초기화
	$paging_str = "";

	// 3. 처음 페이지 링크 만들기
	if ($page > 1) {
		$paging_str .= "<a href='javascript:;' onclick=\"pageGo('".str_replace(".php", "", $_SERVER['PHP_SELF'])."', '".$section."', '".$nowpage."', '', '', '1');\">처음</a>";
	}

	// 4. 페이징에 표시될 시작 페이지 구하기
	$start_page = ((ceil($page / $page_scale) - 1) * $page_scale) + 1;

	// 5. 페이징에 표시될 마지막 페이지 구하기
	$end_page = $start_page + $page_scale - 1;
	if ($end_page >= $total_page)
		$end_page = $total_page;

	// 6. 이전 페이징 영역으로 가는 링크 만들기
	if ($start_page > 1) {
		$paging_str .= " &nbsp;<a href='javascript:;' onclick=\"pageGo('".str_replace(".php", "", $_SERVER['PHP_SELF'])."', '".$section."', '".$nowpage."', '', '', '".($start_page - 1)."');\">이전</a>";
	}

	// 7. 페이지들 출력 부분 링크 만들기
	if ($total_page > 1) {
		for ($i = $start_page; $i <= $end_page; $i++) {
			// 현재 페이지가 아니면 링크 걸기
			if ($page != $i) {
				$paging_str .= " &nbsp;<a href='javascript:;' onclick=\"pageGo('".str_replace(".php", "", $_SERVER['PHP_SELF'])."', '".$section."', '".$nowpage."', '', '', '".$i."');\"><span>$i</span></a>";
				// 현재페이지면 굵게 표시하기
			} else {
				$paging_str .= " &nbsp;<b>$i</b> ";
			}
		}
	}

	// 8. 다음 페이징 영역으로 가는 링크 만들기
	if ($total_page > $end_page) {
		$paging_str .= " &nbsp;<a href='javascript:;' onclick=\"pageGo('".str_replace(".php", "", $_SERVER['PHP_SELF'])."', '".$section."', '".$nowpage."', '', '', '".($end_page + 1)."');\">다음</a>";
	}

	// 9. 마지막 페이지 링크 만들기
	if ($page < $total_page) {
		$paging_str .= " &nbsp;<a href='javascript:;' onclick=\"pageGo('".str_replace(".php", "", $_SERVER['PHP_SELF'])."', '".$section."', '".$nowpage."', '', '', '".$total_page."');\">맨끝</a>";
		//echo $ext;
	}

	return $paging_str;
}

function pagingDate($page='1', $page_row, $page_scale, $total_count, $section='', $nowpage='', $nyear = '', $nmonth = '', $nday = '') {
	// 1. 전체 페이지 계산
	$total_page = ceil($total_count / $page_row);

	// 2. 페이징을 출력할 변수 초기화
	$paging_str = "";

	// 3. 처음 페이지 링크 만들기
	if ($page > 1) {
		$paging_str .= "<a href='javascript:;' onclick=\"pageDateGo('".str_replace(".php", "", $_SERVER['PHP_SELF'])."', '".$section."', '".$nowpage."', '', '', '1', '".$nyear."', '".$nmonth."', '".$nday."');\">처음</a>";
	}

	// 4. 페이징에 표시될 시작 페이지 구하기
	$start_page = ((ceil($page / $page_scale) - 1) * $page_scale) + 1;

	// 5. 페이징에 표시될 마지막 페이지 구하기
	$end_page = $start_page + $page_scale - 1;
	if ($end_page >= $total_page)
		$end_page = $total_page;

	// 6. 이전 페이징 영역으로 가는 링크 만들기
	if ($start_page > 1) {
		$paging_str .= " &nbsp;<a href='javascript:;' onclick=\"pageDateGo('".str_replace(".php", "", $_SERVER['PHP_SELF'])."', '".$section."', '".$nowpage."', '', '', '".($start_page - 1)."', '".$nyear."', '".$nmonth."', '".$nday."');\">이전</a>";
	}

	// 7. 페이지들 출력 부분 링크 만들기
	if ($total_page > 1) {
		for ($i = $start_page; $i <= $end_page; $i++) {
			// 현재 페이지가 아니면 링크 걸기
			if ($page != $i) {
				$paging_str .= " &nbsp;<a href='javascript:;' onclick=\"pageDateGo('".str_replace(".php", "", $_SERVER['PHP_SELF'])."', '".$section."', '".$nowpage."', '', '', '".$i."', '".$nyear."', '".$nmonth."', '".$nday."');\"><span>$i</span></a>";
				// 현재페이지면 굵게 표시하기
			} else {
				$paging_str .= " &nbsp;<b>$i</b> ";
			}
		}
	}

	// 8. 다음 페이징 영역으로 가는 링크 만들기
	if ($total_page > $end_page) {
		$paging_str .= " &nbsp;<a href='javascript:;' onclick=\"pageDateGo('".str_replace(".php", "", $_SERVER['PHP_SELF'])."', '".$section."', '".$nowpage."', '', '', '".($end_page + 1)."', '".$nyear."', '".$nmonth."', '".$nday."');\">다음</a>";
	}

	// 9. 마지막 페이지 링크 만들기
	if ($page < $total_page) {
		$paging_str .= " &nbsp;<a href='javascript:;' onclick=\"pageDateGo('".str_replace(".php", "", $_SERVER['PHP_SELF'])."', '".$section."', '".$nowpage."', '', '', '".$total_page."', '".$nyear."', '".$nmonth."', '".$nday."');\">맨끝</a>";
		//echo $ext;
	}

	return $paging_str;
}
/**
 * navbar 에 class='active' 적용
 * @param String $argName
 * @param String $fixName
 * @return string
 */
function menuClassActive($argName, $fixName){
	$rtnStr = "";
	if($argName == $fixName){
		$rtnStr = "class='active'";
	}else{
		$rtnStr = "";
	}
	return $rtnStr;
}
/**
 * 회원레벨별 등급표시
 * @param number $user_level
 * @return string
 */
function memberLevelView($user_level=0){
	$rtnStr = "";
	if($user_level == 1){
		$rtnStr = "일반회원";
	}else if($user_level == 2){
		$rtnStr = "정회원";
 	}else if($user_level == 9){
 		$rtnStr = "관리자";
	}else if($user_level == 99){
		$rtnStr = "최고관리자";
	}else{
		$rtnStr = "대기회원";
	}
	return $rtnStr;
}
?>