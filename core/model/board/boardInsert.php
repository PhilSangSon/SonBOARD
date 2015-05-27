<?php
// 넘어온 변수 검사
if(trim($bc_code) == ""){
	PageAlert("게시판코드를 입력해 주세요.", "view/admin/board", "boardList");
}

$sql = "select * from bd__board_config where bc_code = '".trim($bc_code)."'";
$data = sql_fetch($sql);
if($data['bc_idx']){
	PageAlert("이미 존재하는 게시판입니다.", "view/admin/board", "boardList");
}

if(trim($bc_name) == ""){
	PageAlert("게시판이름을 입력해 주세요.", "view/admin/board", "boardList");
}

// 파일 저장 디렉토리 검사 후 없으면 생성
$dir = "./data/board_config";

if(!is_dir($dir)){
	@mkdir($dir, 0707);
	@chmod($dir, 0707);
}

// 파일이 jpg나 gif 인지 검사
$bc_head_file = isset($bc_head_file) ? $bc_head_file :"";
$bc_tail_file = isset($bc_tail_file) ? $bc_tail_file :"";
if($_FILES['bc_head_file']['tmp_name']){
	if($_FILES['bc_head_file']['type'] == "image/gif" || $_FILES['bc_head_file']['type'] == "image/jpeg" || $_FILES['bc_head_file']['type'] == "image/png"){
		$bc_head_file = $_FILES['bc_head_file']['name'];
	}else{
		$bc_head_file = "";
	}
}
if($_FILES['bc_tail_file']['tmp_name']){
	if($_FILES['bc_tail_file']['type'] == "image/gif" || $_FILES['bc_tail_file']['type'] == "image/jpeg" || $_FILES['bc_tail_file']['type'] == "image/png"){
		$bc_tail_file = $_FILES['bc_tail_file']['name'];
	}else{
		$bc_tail_file = "";
	}
}

// 게시판 저장
$sql = "insert into bd__board_config set
	        bc_code = '".trim($bc_code)."',
	        bc_name = '".trim($bc_name)."',
	        bc_head_file = '".$bc_head_file."',
	        bc_head = '".$bc_head."',
	        bc_tail_file = '".$bc_tail_file."',
	        bc_tail = '".$bc_tail."',
	        bc_list_level = ".$bc_list_level.",
	        bc_read_level = ".$bc_read_level.",
	        bc_write_level = ".$bc_write_level.",
	        bc_reply_level = ".$bc_reply_level.",
	        bc_comment_level = ".$bc_comment_level.",
	        bc_admin = '".$bc_admin."',
	        bc_use_file = ".$bc_use_file.",
	        bc_use_secret = ".$bc_use_secret.",
	        bc_use_reply = ".$bc_use_reply.",
	        bc_use_comment = ".$bc_use_comment.",
	        bc_regdate = now(),
	        bc_modidate = now()
	        ";
sql_query($sql);

// 저장된 게시판번호 찾기
$bc_idx = mysqli_insert_id($connect);
$head_file = $dir."/".$bc_idx."_head";
$tail_file = $dir."/".$bc_idx."_tail";
// 파일저장
if($_FILES['bc_head_file']['tmp_name'] && $bc_head_file){
	if(file_exists($head_file)){
		@unlink($head_file);
	}
	move_uploaded_file($_FILES['bc_head_file']['tmp_name'], $head_file);
	chmod($head_file, 0666);

}
if($_FILES['bc_tail_file']['tmp_name'] && $bc_tail_file){
	if(file_exists($tail_file)){
		@unlink($tail_file);
	}
	move_uploaded_file($_FILES['bc_tail_file']['tmp_name'], $tail_file);
	chmod($tail_file, 0666);

}
PageAlert("게시판이 생성 되었습니다.", "view/admin/board", "boardList");
?>