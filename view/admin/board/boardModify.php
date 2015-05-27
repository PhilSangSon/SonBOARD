<?php
$page = isset($_REQUEST['page'])?$_REQUEST['page']:1;
$bc_idx = isset($_REQUEST['idx']) ? $_REQUEST['idx'] :"";
// 게시판 설정 데이터 불러오기
$sql = "select * from bd__board_config where bc_idx = '".$bc_idx."'";
$data = sql_fetch($sql);
if(!$data['bc_idx']){
	PageAlert("없는 게시판입니다.", "view/admin/board", "boardList", $page);
}
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
                    	<i class="fa fa-table"></i> 게시판 수정
                	</li>
            	</ol>
        	</div>
    	</div>
        <!-- /.row -->
        
        <div class="row">
       		<div class="col-lg-12">
         		<h2>게시판 입력</h2>
         		<form class="form-signin" name='MyForm' id='MyForm' method='post' enctype="multipart/form-data" onsubmit='return board_modifyCheck();'>
              	<input type='hidden' name='section' id='section' value='core/model'/>
		    	<input type='hidden' name='nowpage' id='nowpage' value='boardController'/>
		    	<input type='hidden' name='mode' id='mode' value='boardModify'/>
		    	<input type='hidden' name='bc_idx' id='bc_idx' value='<?=$bc_idx?>'/>
		    	<input type='hidden' name='page' id='page' value='<?=$page?>'/>
              	<div class="table-responsive">
               		<table class="table table-bordered table-hover">
               			<tbody>
                			<tr>
                  				<td><label for="bc_code">게시판코드</label></td>
                  				<td><input type="text" id="bc_code" name="bc_code" value="<?=$data['bc_code']?>" style="ime-mode:inactive" class="form-control" placeholder="게시판코드" maxlength="50" required autofocus></td>
			                </tr>
							<tr>
			                  	<td><label for="bc_name">게시판이름</label></td>
			                  	<td><input type="text" id="bc_name" name="bc_name" value="<?=$data['bc_name']?>" style="ime-mode:active" class="form-control" placeholder="게시판이름" maxlength="50" required></td>
                			</tr>
							<tr>
                  				<td><label for="bc_head_file">게시판 상단이미지</label></td>
                  				<td><?if($data['bc_head_file']){?><?=$data['bc_head_file']?>&nbsp;<input type="checkbox" name="bc_head_file_del" value="1"> 삭제<br><?}?><input type="file" id="bc_head_file" name="bc_head_file" class="form-control" placeholder="게시판 상단이미지"></td>
                			</tr>
							<tr>
                  				<td><label for="bc_head">게시판상단내용</label></td>
                  				<td><textarea id="bc_head" name="bc_head" class="form-control" placeholder="게시판상단내용"><?=$data['bc_head']?></textarea></td>
                			</tr>
							<tr>
                  				<td><label for="bc_tail">게시판하단내용</label></td>
                  				<td><textarea id="bc_tail" name="bc_tail" class="form-control" placeholder="게시판하단내용"><?=$data['bc_tail']?></textarea></td>
                			</tr>
							<tr>
                  				<td><label for="bc_tail_file">게시판 하단이미지</label></td>
                  				<td><?if($data['bc_tail_file']){?><?=$data['bc_tail_file']?>&nbsp;<input type="checkbox" name="bc_tail_file_del" value="1"> 삭제<br><?}?><input type="file" id="bc_tail_file" name="bc_tail_file" class="form-control" placeholder="게시판 하단이미지"></td>
                			</tr>
							<tr>
                  				<td><label for="bc_list_level">권한설정</label></td>
                  				<td>
									<label for="bc_list_level">목록 레벨 :</label>
									<select id="bc_list_level" name="bc_list_level">
									 <?for($i=0;$i<=9;$i++){?>
										 <option value="<?=$i?>" <?if($data['bc_list_level'] == $i){echo "selected='selected'";}?>><?=$i?></option>
									 <?}?>
									</select><br />
									<label for="bc_read_level">읽기 레벨 :</label>
									<select id="bc_read_level" name="bc_read_level">
									 <?for($i=0;$i<=9;$i++){?>
										 <option value="<?=$i?>" <?if($data['bc_read_level'] == $i){echo "selected='selected'";}?>><?=$i?></option>
									 <?}?>
									</select><br />
									<label for="bc_write_level">쓰기 레벨 :</label>
									<select id="bc_write_level" name="bc_write_level">
									 <?for($i=0;$i<=9;$i++){?>
										 <option value="<?=$i?>" <?if($data['bc_write_level'] == $i){echo "selected='selected'";}?>><?=$i?></option>
									 <?}?>
									</select><br />
									<label for="bc_reply_level">답글 레벨 :</label>
									<select id="bc_reply_level" name="bc_reply_level">
									 <?for($i=0;$i<=9;$i++){?>
										 <option value="<?=$i?>" <?if($data['bc_reply_level'] == $i){echo "selected='selected'";}?>><?=$i?></option>
									 <?}?>
									</select><br />
									<label for="bc_comment_level">댓글 레벨 :</label>
									<select id="bc_comment_level" name="bc_comment_level">
									 <?for($i=0;$i<=9;$i++){?>
										 <option value="<?=$i?>" <?if($data['bc_comment_level'] == $i){echo "selected='selected'";}?>><?=$i?></option>
									 <?}?>
									</select>
				  				</td>
                			</tr>
							<tr>
                  				<td><label for="bc_admin">게시판 관리자ID</label></td>
                  				<td><input type="text" id="bc_admin" name="bc_admin" style="ime-mode:inactive" value="<?=$data['bc_admin']?>" class="form-control" placeholder="게시판 관리자ID" required></td>
                			</tr>
							<tr>
                  				<td><label for="bc_use_file">파일 업로드 사용</label></td>
                  				<td><input type="checkbox" id="bc_use_file" name="bc_use_file" value="1" <?if($data['bc_use_file'] == 1){echo "checked='checked'";}?> title="파일 업로드 사용">사용</td>
                			</tr>
							<tr>
                  				<td><label for="bc_use_secret">비밀글 사용</label></td>
                  				<td><input type="checkbox" id="bc_use_secret" name="bc_use_secret" value="1" <?if($data['bc_use_secret'] == 1){echo "checked='checked'";}?> title="비밀글 사용">사용</td>
                			</tr>
							<tr>
                  				<td><label for="bc_use_reply">답글 사용</label></td>
                  				<td><input type="checkbox" id="bc_use_reply" name="bc_use_reply" value="1" <?if($data['bc_use_reply'] == 1){echo "checked='checked'";}?> title="답글 사용">사용</td>
                			</tr>
							<tr>
                  				<td><label for="bc_use_comment">댓글 사용</label></td>
                  				<td><input type="checkbox" id="bc_use_comment" name="bc_use_comment" value="1" <?if($data['bc_use_comment'] == 1){echo "checked='checked'";}?> title="댓글 사용">사용</td>
                			</tr>
              			</tbody>
               		</table>
               		<table class="table table-striped">
						<tr>
							<td>
								<button class="btn btn-lg btn-primary btn-block" type="submit">게시판수정</button>
							</td>
							<td>
								<button class="btn btn-lg btn-danger btn-block" type="button" onclick="board_delete('<?=$data['bc_idx']?>');">삭제</button>
							</td>
							<td>
								<button class="btn btn-lg btn-info btn-block" type="button" onclick="pageGo('admin_index','view/admin/board','boardList','','','<?=$page?>');">뒤로가기</button>
							</td>
						</tr>
					</table>
               	</div>
               	</form>
           	</div>
      	</div>
      	<!-- /.row -->
      	
  	</div>
  	
</div>