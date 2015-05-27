<?php
// 회원 존재여부 검사
$sql = "select * from bd__member where m_idx = '".$m_idx."'";
$data = sql_fetch($sql);
if(!$data['m_idx']){
	PageAlert("없는 회원입니다.", "view/admin/member", "memberList", $page);
}

// 넘어온 변수 검사
if(trim($m_name) == ""){
	PageAlert("회원이름을 입력해 주세요.", "view/admin/member", "memberList", $page);
}
if(trim($m_pass) == ""){
	PageAlert("비밀번호를 입력해 주세요.", "view/admin/member", "memberList", $page);
}

// 회원 저장
$sql = "update bd__member set
        m_name = '".trim($m_name)."',
		m_pass = HEX(AES_ENCRYPT('".trim($m_pass)."', 'thsvlftkdWkd')),
		m_stat = '".$m_stat."',
        m_level = '".$m_level."'
        where m_idx = '".$m_idx."'
        ";
sql_query($sql);

// 이름이 바귀었으면 회원 글과 코멘트의 이름 수정
if($data['m_name'] != trim($m_name)){
	$sql = "update bd__board set m_name ='".trim($m_name)."' where m_id = '".$data['m_id']."'";
	sql_query($sql);

	$sql = "update bd__comment set m_name ='".trim($m_name)."' where m_id = '".$data['m_id']."'";
	sql_query($sql);
}
// 회원목록 페이지로 보내기
PageAlert("회원이 수정 되었습니다.", "view/admin/member", "memberList", $page);
?>