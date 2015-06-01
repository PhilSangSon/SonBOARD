<?php
$mode    = isset($_REQUEST['mode'])    ? $_REQUEST['mode']    :"";
$page    = isset($_REQUEST['page'])    ? $_REQUEST['page']:1;
$bc_idx  = isset($_REQUEST['bc_idx'])  ? $_REQUEST['bc_idx']  :0;
$bc_code = isset($_REQUEST['bc_code']) ? $_REQUEST['bc_code'] :"";
$bc_name = isset($_REQUEST['bc_name']) ? $_REQUEST['bc_name'] :"";
$bc_head = isset($_REQUEST['bc_head']) ? $_REQUEST['bc_head'] :"";
$bc_tail = isset($_REQUEST['bc_tail']) ? $_REQUEST['bc_tail'] :"";
$bc_head_file_del = isset($_REQUEST['bc_head_file_del']) ? $_REQUEST['bc_head_file_del'] :"";
$bc_tail_file_del = isset($_REQUEST['bc_tail_file_del']) ? $_REQUEST['bc_tail_file_del'] :"";
$bc_list_level    = isset($_REQUEST['bc_list_level'])    ? $_REQUEST['bc_list_level'] :0;
$bc_read_level    = isset($_REQUEST['bc_read_level'])    ? $_REQUEST['bc_read_level'] :0;
$bc_write_level   = isset($_REQUEST['bc_write_level'])   ? $_REQUEST['bc_write_level'] :0;
$bc_reply_level   = isset($_REQUEST['bc_reply_level'])   ? $_REQUEST['bc_reply_level'] :0;
$bc_comment_level = isset($_REQUEST['bc_comment_level']) ? $_REQUEST['bc_comment_level'] :0;
$bc_admin         = isset($_REQUEST['bc_admin'])         ? $_REQUEST['bc_admin'] :"";
$bc_use_file      = isset($_REQUEST['bc_use_file'])      ? $_REQUEST['bc_use_file'] :0;
$bc_use_secret    = isset($_REQUEST['bc_use_secret'])    ? $_REQUEST['bc_use_secret'] :0;
$bc_use_reply     = isset($_REQUEST['bc_use_reply'])     ? $_REQUEST['bc_use_reply'] :0;
$bc_use_comment   = isset($_REQUEST['bc_use_comment'])   ? $_REQUEST['bc_use_comment'] :0;
$articlePage = isset($_REQUEST['articlePage'])?$_REQUEST['articlePage']:1;
$b_title = isset($_REQUEST['b_title']) ? $_REQUEST['b_title'] :"";
$b_contents = isset($_REQUEST['b_contents']) ? $_REQUEST['b_contents'] :"";
$b_notice       = isset($_REQUEST['b_notice']) ? $_REQUEST['b_notice'] :0;
$b_is_secret    = isset($_REQUEST['b_is_secret'])    ? $_REQUEST['b_is_secret'] :0;
$b_pass = isset($_REQUEST['b_pass']) ? $_REQUEST['b_pass'] :"";
$m_name = isset($_REQUEST['m_name']) ? $_REQUEST['m_name'] :"";

if($mode == 'boardInsert'){
	require './core/model/board/boardInsert.php';
}else if($mode == 'boardModify'){
	require './core/model/board/boardModify.php';
}else if($mode == 'boardDelete'){
	require './core/model/board/boardDelete.php';
}else if($mode == 'articleInsert'){
	require './core/model/board/articleInsert.php';
}
?>