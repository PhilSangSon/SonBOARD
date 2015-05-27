<?php
// 게시판 존재여부 검사
$sql = "select * from bd__board_config where bc_idx = '".$bc_idx."'";
$data = sql_fetch($sql);
if(!$data['bc_idx']){
	PageAlert("없는 게시판입니다.", "view/admin/board", "boardList", $page);
}

$dir = "./data/board_config";
$head_file = $dir."/".$bc_idx."_head";
$tail_file = $dir."/".$bc_idx."_tail";

// 파일 삭제
@unlink($head_file);
@unlink($tail_file);

// 게시판 삭제
$sql = "delete from bd__board_config where bc_idx = '".$bc_idx."'";
sql_query($sql);

// 코멘트 및 파일 삭제를 위한 게시글 목록 구하기
$sql = "select * from bd__board where bc_code = '".$data['bc_code']."'";
$data1 = sql_list($sql);

// 게시글 삭제
$sql = "delete from bd__board where bc_code = '".$data['bc_code']."'";
sql_query($sql);

// 코멘트 및 게시물 파일 삭제
for($i=0;$i<count($data1);$i++){
	$sql = "delete from bd__comment where b_idx = '".$data1['b_idx']."'";
	sql_query($sql);

	$b_file = "./data/".$data1['b_idx'];
	@unlink($b_file);
}

// 게시판목록 페이지로 보내기
PageAlert("게시판이 삭제 되었습니다.", "view/admin/board", "boardList", $page);
?>