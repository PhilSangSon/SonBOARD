<?php
// 회원 존재여부 검사
$sql = "select * from bd__member where m_idx = '".$m_idx."'";
$data = sql_fetch($sql);
if(!$data['m_idx']){
	PageAlert("없는 회원입니다.", "view/admin/member", "memberList", $page);
}

// 회원 삭제
$sql = "delete from bd__member where m_idx = '".$m_idx."'";
sql_query($sql);

// 글에 딸린 코멘트 및 파일 삭제를 위한 게시글 목록 구하기
$sql = "select * from bd__board where m_id = '".$data['m_id']."'";
$data1 = sql_list($sql);

// 게시글 삭제
$sql = "delete from bd__board where m_id = '".$data['m_id']."'";
sql_query($sql);

// 게시글에 딸린 코멘트 및 게시물 파일 삭제
for($i=0;$i<count($data1);$i++){
	$sql = "delete from bd__comment where b_idx = '".$data1['b_idx']."'";
	sql_query($sql);

	$b_file = "./data/".$data1['b_idx'];
	@unlink($b_file);
}

// 코멘트 삭제
$sql = "delete from bd__comment where m_id = '".$data1['m_id']."'";
sql_query($sql);

// 회원목록 페이지로 보내기
PageAlert("회원이 삭제 되었습니다.", "view/admin/member", "memberList", $page);
?>