<?php
require_once './config/config.php';
$m_id = isset($_REQUEST['m_id']) ? $_REQUEST['m_id'] :"";
$sql = "select m_idx from bd__member where m_id = '".$m_id."'";
$data = sql_fetch($sql);
if(!$data['m_idx']){
	echo true;
}else{
	echo false;
}
?>