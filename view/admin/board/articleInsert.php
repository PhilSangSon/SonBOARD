<?php
$articlePage = isset($_REQUEST['articlePage'])?$_REQUEST['articlePage']:1;
$bc_code = isset($_REQUEST['idx']) ? $_REQUEST['idx'] :"";
if($bc_code != ""){
	// 게시판 코드가 있으면 게시판 설정 불러오기
	$b_config_sql = "select * from ".$_cfg['config_table']." where bc_code = '".$bc_code."'";
	$board_config = sql_fetch($b_config_sql);
}else{
	ArticleAlert("게시판 코드가 없습니다.", "view/admin/board", "articleList", $articlePage);
}
// 존재하는 게시판인지 확인
if(!$board_config['bc_idx']){
	ArticleAlert("존재 하지 않는 게시판입니다.", "view/admin/board", "articleList", $articlePage);
}

// 게시판 권한 체크
if($_SESSION['user_level']){
	$u_level = $_SESSION['user_level'];
}else{
	$u_level = 0;
}

if($u_level < $board_config['bc_list_level']){
	ArticleAlert("권한이 없습니다.", "view/admin/board", "articleList", $articlePage);
}
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
                    	<i class="fa fa-table"></i> <?=$board_config['bc_name']?> 쓰기
                	</li>
            	</ol>
        	</div>
    	</div>
        <!-- /.row -->
        
        <div class="row">
       		<div class="col-lg-12">
         		<h2><?=$board_config['bc_name']?> 입력</h2>
         		<form class="form-signin" name='MyForm' id='MyForm' method='post' enctype="multipart/form-data" onsubmit='return article_insertCheck();'>
              	<input type='hidden' name='section' id='section' value='core/model'/>
		    	<input type='hidden' name='nowpage' id='nowpage' value='boardController'/>
		    	<input type='hidden' name='mode' id='mode' value='articleInsert'/>
		    	<input type='hidden' name='bc_code' id='bc_code' value='<?=$bc_code?>'/>
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
			                	<th colspan="2" style="padding:0px"><img src="<?=$head_file?>"></th>
			                </tr>
                	<?
                	}
                	// 게시판 상단 내용 출력
                	if($board_config['bc_head'] != ""){
                	?>
                			<tr>
			                	<th colspan="2" style="padding:0px"><?=$board_config['bc_head']?></th>
			                </tr>
                	<?
                	}
                	?>
               			</thead>
               			<tbody>
               				<tr>
               					<td style="width:20%"><label for="b_title">글제목</label></td>
               					<td><input type="text" id="b_title" name="b_title" style="ime-mode:active" class="form-control" placeholder="글제목" maxlength="100" required autofocus></td>
               				</tr>
               			<?php 
               			// 로그인 한 상태가 아니면 이름을 쓰고 로그인 했으면 hidden으로 넘긴다.
               			if(!$_SESSION['user_idx']){
               			?>
               				<tr>
               					<td><label for="m_name">작성자명</label></td>
               					<td><input type="text" id="m_name" name="m_name" style="ime-mode:active" class="form-control" placeholder="작성자명" maxlength="30" required autofocus></td>
               				</tr>
               			<?
               			}else{
               			?>
               				<input type='hidden' name='m_name' id='m_name' value='<?=$_SESSION['user_name']?>'/>
               			<?
               			}
               			// 관리자 레벨 이상이면 공지글 체크 가능
               			if($u_level >= 9){
               			?>
               				<tr>
               					<td><label for="b_notice">공지글 여부</label></td>
               					<td><input type="checkbox" id="b_notice" name="b_notice" value="1" title="공지글"><label for="b_notice" style="vertical-align:middle">공지글 이면 체크</label></td>
               				</tr>
               			<?
               			}
               			// 비밀글을 사용하면 비밀글 체크 여부와 비밀번호 입력받기
               			if($board_config['bc_use_secret']){
               			?>
               				<tr>
               					<td><label for="b_is_secret">비밀글 여부</label></td>
               					<td><input type="checkbox" id="b_is_secret" name="b_is_secret" value="1" title="비밀글"><label for="b_is_secret" style="vertical-align:middle">비밀글 이면 체크</label></td>
               				</tr>
               				<tr>
                  				<td><label for="b_pass">비밀번호</label></td>
                  				<td><input type="text" id="b_pass" name="b_pass" style="ime-mode:inactive" class="form-control" placeholder="비밀번호" maxlength="20" required></td>
			                </tr>
               			<?
               			}
               			// 파일 업로드를 사용하면 파일 입력
               			if($board_config['bc_use_file']){
               			?>
               				<tr>
                  				<td><label for="b_file">첨부파일</label></td>
                  				<td><input type="file" id="b_file" name="b_file" class="form-control" placeholder="첨부파일"></td>
                			</tr>
               			<?
               			}
               			?>
               				<tr>
                  				<td><label for="b_contents">글내용</label></td>
                  				<td><textarea name="b_contents" style="width:800px;height:200px;"></textarea></td>
                			</tr>
               				<tr>
               					<td colspan="2">
               						<table style="width:100%">
               							<tr>
											<td style="width:50%;padding:10px">
												<button class="btn btn-lg btn-primary btn-block" type="submit">글쓰기</button>
											</td>
											<td style="width:50%;padding:10px">
												<button class="btn btn-lg btn-info btn-block" type="button" onclick="pageArticleGo('admin_index','view/admin/board','articleList','','<?=$bc_code?>','<?=$articlePage?>');">뒤로가기</button>
											</td>
										</tr>
               						</table>
               					</td>
               				</tr>
               			</tbody>
               			<tfoot>
               		<?php
					// 게시판 하단 내용 출력
					if($board_config['bc_tail'] != ""){
					?>
							<tr>
								<th colspan="2" style="padding:0px"><?=$board_config['bc_tail']?></th>
							</tr>
					<?
					}
					// 게시판 하단 이미지 출력
					$dir = "./data/board_config";
					$tail_file = $dir."/".$board_config['bc_idx']."_tail";
					
					if($board_config['bc_tail_file'] && file_exists($tail_file)){
					?>
							<tr>
								<th colspan="2" style="padding:0px"><img src="<?=$tail_file?>"></th>
							</tr>
					<?
					}
					?>
               			</tfoot>
               		</table>
               	</div>
         		</form>
         	</div>
     	</div>
     	<!-- /.row -->
     	
	</div>
     	
</div>