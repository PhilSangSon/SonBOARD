<?php
$mode    = isset($_REQUEST['mode'])    ? $_REQUEST['mode']    :"";
$bc_code = isset($_REQUEST['bc_code']) ? $_REQUEST['bc_code'] :"";
$bc_name = isset($_REQUEST['bc_name']) ? $_REQUEST['bc_name'] :"";
$bc_head = isset($_REQUEST['bc_head']) ? $_REQUEST['bc_head'] :"";
$bc_tail = isset($_REQUEST['bc_tail']) ? $_REQUEST['bc_tail'] :"";
$bc_list_level = isset($_REQUEST['bc_list_level']) ? $_REQUEST['bc_list_level'] :0;
$bc_read_level = isset($_REQUEST['bc_read_level']) ? $_REQUEST['bc_read_level'] :0;
$bc_write_level = isset($_REQUEST['bc_write_level']) ? $_REQUEST['bc_write_level'] :0;
$bc_reply_level = isset($_REQUEST['bc_reply_level']) ? $_REQUEST['bc_reply_level'] :0;
$bc_comment_level = isset($_REQUEST['bc_comment_level']) ? $_REQUEST['bc_comment_level'] :0;
$bc_admin = isset($_REQUEST['bc_admin']) ? $_REQUEST['bc_admin'] :"";
$bc_use_file = isset($_REQUEST['bc_use_file']) ? $_REQUEST['bc_use_file'] :0;
$bc_use_secret = isset($_REQUEST['bc_use_secret']) ? $_REQUEST['bc_use_secret'] :0;
$bc_use_reply = isset($_REQUEST['bc_use_reply']) ? $_REQUEST['bc_use_reply'] :0;
$bc_use_comment = isset($_REQUEST['bc_use_comment']) ? $_REQUEST['bc_use_comment'] :0;

if($mode == 'boardInsert'){
	require './core/model/board/boardInsert.php';
}
?>