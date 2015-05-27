<?php
$mode    = isset($_REQUEST['mode'])    ? $_REQUEST['mode']   :"";
$m_id    = isset($_REQUEST['m_id'])    ? $_REQUEST['m_id']   :"";
$m_pass  = isset($_REQUEST['m_pass'])  ? $_REQUEST['m_pass'] :"";
$idcheck = isset($_REQUEST['idcheck']) ? $_REQUEST['idcheck']:"";

if($mode == 'login'){
	require './core/model/member/login.php';
}else if($mode == 'logout'){
	require './core/model/member/logout.php';
}
?>