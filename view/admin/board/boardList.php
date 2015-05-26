<?php
// 페이지 변수 설정
$page = isset($_REQUEST['page'])?$_REQUEST['page']:1;
// 한 페이지에 보일 글 수
$page_row = 10;
// 한줄에 보여질 페이지 수
$page_scale = 10;
// 페이징을 출력할 변수 초기화
$paging_str = "";

// 전체 게시판 갯수 알아내기
$sql = "select count(*) as cnt from bd__board_config where 1";
$total_count = sql_total($sql);
// 페이지 출력 내용 만들기
$paging_str = paging($page, $page_row, $page_scale, $total_count);

// 시작 열을 구함
$from_record = ($page - 1) * $page_row;

// 글목록 구하기
$query = "select * from bd__board_config where 1 order by bc_idx desc limit ".$from_record.", ".$page_row;
$data = sql_list($query);

?>
<div id="page-wrapper">

 	<div class="container-fluid">

    	<!-- Page Heading -->
        <div class="row">
        	<div class="col-lg-12">
            	<h1 class="page-header">
                	게시판 관리
                </h1>
                <ol class="breadcrumb">
                   	<li>
                    	<i class="fa fa-dashboard"></i>  <a href="admin_index.php">홈</a>
                    </li>
               		<li class="active">
                    	<i class="fa fa-table"></i> 게시판 목록
                	</li>
            	</ol>
        	</div>
    	</div>
        <!-- /.row -->
	</div>
	
</div>