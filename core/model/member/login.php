<?php
if(trim($m_id) == ""){
	alert("아이디를 입력해주세요.");
}
if(trim($m_pass) == ""){
	alert("비밀번호를 입력해주세요.");
}
// 같은 아이디 검사
$chk_sql = "select AES_DECRYPT(UNHEX(m_pass), 'thsvlftkdWkd') As m_pass, m_idx, m_id, m_name, m_level from bd__member where m_id = '".trim($m_id)."'";
$chk_result = sql_query($chk_sql);
$chk_data = mysqli_fetch_array($chk_result);
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
?>