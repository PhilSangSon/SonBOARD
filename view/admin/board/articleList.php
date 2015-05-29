<?php
$page = isset($_REQUEST['page'])?$_REQUEST['page']:1;
$bc_code = isset($_REQUEST['idx']) ? $_REQUEST['idx'] :"";
if($bc_code != ""){
	// 게시판 코드가 있으면 게시판 설정 불러오기
	$b_config_sql = "select * from ".$_cfg['config_table']." where bc_code = '".$bc_code."'";
	$board_config = sql_fetch($b_config_sql);
}else{
	PageAlert("게시판 코드가 없습니다.", "view/admin/board", "boardList", $page);
}
// 존재하는 게시판인지 확인
if(!$board_config['bc_idx']){
	PageAlert("존재 하지 않는 게시판입니다.", "view/admin/board", "boardList", $page);
}

// 게시판 권한 체크
if($_SESSION['user_level']){
	$u_level = $_SESSION['user_level'];
}else{
	$u_level = 0;
}

if($u_level < $board_config['bc_list_level']){
	PageAlert("권한이 없습니다.", "view/admin/board", "boardList", $page);
}

$articlePage = isset($_REQUEST['articlePage'])?$_REQUEST['articlePage']:1;
// 한 페이지에 보일 글 수
$page_row = 10;
// 한줄에 보여질 페이지 수
$page_scale = 10;
// 페이징을 출력할 변수 초기화
$paging_str = "";
// 전체 글 갯수 알아내기
$sql = "select count(*) as cnt from ".$_cfg['board_table']." where bc_code = '".$bc_code."' ";
$total_count = sql_total($sql);

// 페이지 출력 내용 만들기
$paging_str = pagingArticle($articlePage, $page_row, $page_scale, $total_count, "view/admin/board", "articleList");

// 시작 열을 구함
$from_record = ($articlePage - 1) * $page_row;

// 글목록 구하기
$query = "select * from ".$_cfg['board_table']." where bc_code = '".$bc_code."' order by b_num desc, b_reply asc limit ".$from_record.", ".$page_row;
$result = mysqli_query($connect, $query);
?>
<div id="page-wrapper">

 	<div class="container-fluid">

    	<!-- Page Heading -->
        <div class="row">
        	<div class="col-lg-12">
            	<h1 class="page-header">
                	<?=$board_config['bc_name']?> 관리
                </h1>
                <ol class="breadcrumb">
                   	<li>
                    	<i class="fa fa-dashboard"></i>  <a href="admin_index.php">홈</a>
                    </li>
               		<li class="active">
                    	<i class="fa fa-table"></i> <?=$board_config['bc_name']?> 목록
                	</li>
            	</ol>
        	</div>
    	</div>
        <!-- /.row -->
        
        <div class="row">
       		<div class="col-lg-12">
         		<h2><?=$board_config['bc_name']?> 리스트</h2>
              	<div class="table-responsive">
               		<table class="table table-bordered table-hover">
                		<thead>
                	<?
                	// 게시판 상단 이미지 출력
                	$dir = "./data/board_config";
                	$head_file = $dir."/".$board_config['bc_idx']."_head";
                	
                	if($board_config['bc_head_file'] && file_exists($head_file)){
                	?>
			                <tr>
			                	<th colspan="4" style="padding:0px"><img src="<?=$head_file?>"></th>
			                </tr>
                	<?
                	}
                	// 게시판 상단 내용 출력
                	if($board_config['bc_head'] != ""){
                	?>
                			<tr>
			                	<th colspan="4" style="padding:0px"><?=$board_config['bc_head']?></th>
			                </tr>
                	<?
                	}
                	?>
                        	<tr>
                       			<th>번호</th>
                         		<th>글제목</th>
                         		<th>글쓴이</th>
                           		<th>작성일</th>
                    		</tr>
               			</thead>
                  		<tbody>
                  	<?php
                  	// 데이터 갯수 체크를 위한 변수 설정
                  	$i = 0;
                  	// 데이터가 있을 동안 반복해서 값을 한 줄씩 읽기
                  	while($data = mysqli_fetch_array($result)){
                  	
                  		// 댓글 앞에 붙을 기호 만들기
                  		$reply_str = "";
                  		$reply_depth = strlen($data[b_reply]);
                  		if ($reply_depth > 0){
                  			for ($k=0; $k<$reply_depth; $k++){
                  				$reply_str .= '&nbsp;&nbsp;&nbsp;';
                  			}
                  			$reply_str .= "┗";
                  		}
                  	
                  		// 게시글 링크 및 비밀글표시 만들기
                  		$mark_secret = "";
                  		if($data[b_is_secret]){
                  			$mark_secret = "[비밀글] ";
                  		}
                  		// 게시글을 볼 권한 여부에 따라서
                  		if($u_level >= $board_config[bc_read_level]){
                  			// 비밀글 여부 따지기
                  			if($data[b_is_secret]){
                  				// 글쓴이와 관리자 여부 따지기
                  				if($_SESSION[user_id] == $data[m_id] || $_SESSION[user_id] == 9 || ($_SESSION[user_id] == $board_config[bc_admin] && $board_config[bc_admin])){
                  					$article_link = "./board_view.php?bc_code=".$bc_code."&b_idx=".$data[b_idx]."&page=".$page;
                  				}else{
                  					$article_link = "./board_password.php?bc_code=".$bc_code."&b_idx=".$data[b_idx]."&page=".$page;
                  				}
                  			}else{
                  				$article_link = "./board_view.php?bc_code=".$bc_code."&b_idx=".$data[b_idx]."&page=".$page;
                  			}
                  		}else{
                  			$article_link = "javascript:alert('글을 읽을 권한이 없습니다.');";
                  		}
                  	?>
                  	
                  	<?php 
                  	$i++;
                  	}
                  	// 데이터가 하나도 없으면
                  	if($i == 0){
                  	?>
	                  	    <tr>
	                  	        <td colspan="4" style="text-align:center">게시글이 하나도 없습니다.</td>
	                  	    </tr>
                  	<?
                  	}
                  	?>
                  		</tbody>
                  		<tfoot>
                  			<tr>
						        <th colspan="4" style="text-align:center"><?=$paging_str?></th>
						    </tr>
					<?php 
					// 권한 체크 후 글쓰기 버튼 보여주기
					if($u_level >= $board_config['bc_write_level']){
					?>
							<tr>
								<th colspan="4" style="text-align:center">
									<button type="button" class="btn btn-primary btn-block" onclick="pageArticleGo('admin_index', 'view/admin/board', 'articleInsert', '', '<?=$bc_code?>', '<?=$articlePage?>');">글쓰기</button>
								</th>
							</tr>
					<?php
					}
					// 게시판 하단 내용 출력
					if($board_config['bc_tail'] != ""){
					?>
							<tr>
								<th colspan="4" style="padding:0px"><?=$board_config['bc_tail']?></th>
							</tr>
					<?
					}
					// 게시판 하단 이미지 출력
					$dir = "./data/board_config";
					$tail_file = $dir."/".$board_config['bc_idx']."_tail";
					
					if($board_config['bc_tail_file'] && file_exists($tail_file)){
					?>
							<tr>
								<th colspan="4" style="padding:0px"><img src="<?=$tail_file?>"></th>
							</tr>
					<?
					}
					?>
                  		</tfoot>
                  	</table>
              	</div>
         	</div>
    	</div>
    	<!-- /.row -->
    	
	</div>
</div>