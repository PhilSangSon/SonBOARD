<?php
// 넘어온 변수 검사
if(trim($m_id) == ""){
	PageAlert("회원아이디를 입력해 주세요.", "view/admin/member", "memberList", $page);
}
if(trim($m_name) == ""){
	PageAlert("회원이름을 입력해 주세요.", "view/admin/member", "memberList", $page);
}
if(trim($m_pass) == ""){
	PageAlert("비밀번호를 입력해 주세요.", "view/admin/member", "memberList", $page);
}
if($m_pass != $m_passRe){
	PageAlert("비밀번호를 확인해 주세요.", "view/admin/member", "memberList", $page);
}

// 같은 아이디가 있는지 검사
$chk_sql = "select * from bd__member where m_id = '".trim($m_id)."'";
$chk_result = sql_query($chk_sql);
$chk_data = mysqli_fetch_array($chk_result);

// 가입된 아이디가 있으면 되돌리기
if($chk_data['m_idx']){
	PageAlert("이미 가입된 아이디 입니다.", "view/admin/member", "memberList", $page);
}

// 회원정보 적기
$sql = "insert into bd__member (m_id, m_name, m_pass, m_level, m_stat, m_regdate) values ('".trim($m_id)."', '".trim($m_name)."', HEX(AES_ENCRYPT('".$m_pass."', 'thsvlftkdWkd')), ".$m_level.", '".$m_stat."', now())";
sql_query($sql);
// 회원목록 페이지로 보내기
PageAlert("회원이 등록 되었습니다.", "view/admin/member", "memberList", $page);
?>