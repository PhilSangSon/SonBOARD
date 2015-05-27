<?php
$mode    = isset($_REQUEST['mode'])    ? $_REQUEST['mode']   :"";
$page    = isset($_REQUEST['page'])    ? $_REQUEST['page']   :1;
$m_idx   = isset($_REQUEST['m_idx'])   ? $_REQUEST['m_idx']  :0;
$m_id    = isset($_REQUEST['m_id'])    ? $_REQUEST['m_id']   :"";
$m_pass  = isset($_REQUEST['m_pass'])  ? $_REQUEST['m_pass'] :"";
$m_passRe  = isset($_REQUEST['m_passRe'])  ? $_REQUEST['m_passRe'] :"";
$idcheck = isset($_REQUEST['idcheck']) ? $_REQUEST['idcheck']:"";
$m_name  = isset($_REQUEST['m_name'])  ? $_REQUEST['m_name'] :"";
$m_stat  = isset($_REQUEST['m_stat'])  ? $_REQUEST['m_stat'] :"Y";
$m_level = isset($_REQUEST['m_level']) ? $_REQUEST['m_level']:0;

if($mode == 'login'){
	require './core/model/member/login.php';
}else if($mode == 'logout'){
	require './core/model/member/logout.php';
}else if($mode == 'memberModify'){
	require './core/model/member/memberModify.php';
}else if($mode == 'memberDelete'){
	require './core/model/member/memberDelete.php';
}else if($mode == 'memberInsert'){
	require './core/model/member/memberInsert.php';
}
?>