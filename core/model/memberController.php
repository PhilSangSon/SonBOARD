<?php
$mode    = isset($_REQUEST['mode'])    ? $_REQUEST['mode']   :"";
$m_id    = isset($_REQUEST['m_id'])    ? $_REQUEST['m_id']   :"";
$m_pass  = isset($_REQUEST['m_pass'])  ? $_REQUEST['m_pass'] :"";
$idcheck = isset($_REQUEST['idcheck']) ? $_REQUEST['idcheck']:"";

if($mode == 'login'){
	if(trim($m_id) == ""){
		alert("아이디를 입력해주세요.");
	}
	if(trim($m_pass) == ""){
		alert("비밀번호를 입력해주세요.");
	}
	// 같은 아이디 검사
	$sql1="SET TRANSACTION ISOLATION LEVEL READ UNCOMMITTED";
	sql_query($sql1);
	$chk_sql = "select AES_DECRYPT(UNHEX(m_pass), 'thsvlftkdWkd') As m_pass, m_idx, m_id, m_name, m_level from bd__member where m_id = '".trim($m_id)."'";
	$chk_result = sql_query($chk_sql);
	$chk_data = mysqli_fetch_array($chk_result);
	$sql2="COMMIT";
	sql_query($sql2);
	// 아이디 존재함.
	if($chk_data['m_idx']){
	
		// 입력된 비밀번호와 저장된 비밀번호가 같은지 비교해서
		if($m_pass == $chk_data['m_pass']){
			// 비밀번호가 같으면 세션값 부여 후 이동
			$_SESSION['user_idx'] = $chk_data['m_idx'];
			$_SESSION['user_id'] = $chk_data['m_id'];
			$_SESSION['user_name'] = $chk_data['m_name'];
			$_SESSION['user_level'] = $chk_data['m_level'];
	
			// 아이디 쿠키처리
			if($idcheck == "on"){
				setcookie('c_id', trim($m_id), time()+(60*60*24));
			}else{
				setcookie('c_id');
			}
	
			alert("환영합니다.", "./index.php");
	
		}else{
			// 비밀번호가 다르면
			PageAlert("비밀번호가 다릅니다.", "view/admin/member", "login");
		}
	}else{
		// 아이디가 존재하지 않으면
		PageAlert("존재하지 않는 회원입니다.", "view/admin/member", "login");
	}
}else if($mode == 'logout'){
	// 모든 세션값을 빈값으로
	$_SESSION['user_idx'] = "";
	$_SESSION['user_id'] = "";
	$_SESSION['user_name'] = "";
	$_SESSION['user_level'] = "";
	session_destroy();
	alert("로그아웃이 되었습니다.", "./admin_index.php");
}
?>