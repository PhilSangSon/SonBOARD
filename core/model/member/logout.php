<?php
// 모든 세션값을 빈값으로
$_SESSION['user_idx'] = "";
$_SESSION['user_id'] = "";
$_SESSION['user_name'] = "";
$_SESSION['user_level'] = "";
session_destroy();
alert("로그아웃이 되었습니다.", "./admin_index.php");
?>