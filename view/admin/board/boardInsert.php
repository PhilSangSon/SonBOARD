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
                    	<i class="fa fa-table"></i> 게시판 생성
                	</li>
            	</ol>
        	</div>
    	</div>
        <!-- /.row -->
        
        <div class="row">
       		<div class="col-lg-12">
         		<h2>게시판 입력</h2>
         		<form class="form-signin" name='MyForm' id='MyForm' method='post' enctype="multipart/form-data" onsubmit='return board_insertCheck();'>
              	<input type='hidden' name='section' id='section' value='core/model'/>
		    	<input type='hidden' name='nowpage' id='nowpage' value='boardController'/>
		    	<input type='hidden' name='mode' id='mode' value='boardInsert'/>
              	<div class="table-responsive">
               		<table class="table table-bordered table-hover">
               			<tbody>
                			<tr>
                  				<td><label for="bc_code">게시판코드</label></td>
                  				<td><input type="text" id="bc_code" name="bc_code" style="ime-mode:inactive" class="form-control" placeholder="게시판코드" maxlength="50" required autofocus></td>
			                </tr>
							<tr>
			                  	<td><label for="bc_name">게시판이름</label></td>
			                  	<td><input type="text" id="bc_name" name="bc_name" style="ime-mode:active" class="form-control" placeholder="게시판이름" maxlength="50" required></td>
                			</tr>
							<tr>
                  				<td><label for="bc_head_file">게시판 상단이미지</label></td>
                  				<td><input type="file" id="bc_head_file" name="bc_head_file" class="form-control" placeholder="게시판 상단이미지"></td>
                			</tr>
							<tr>
                  				<td><label for="bc_head">게시판상단내용</label></td>
                  				<td><textarea id="bc_head" name="bc_head" class="form-control" placeholder="게시판상단내용"></textarea></td>
                			</tr>
							<tr>
                  				<td><label for="bc_tail">게시판하단내용</label></td>
                  				<td><textarea id="bc_tail" name="bc_tail" class="form-control" placeholder="게시판하단내용"></textarea></td>
                			</tr>
							<tr>
                  				<td><label for="bc_tail_file">게시판 하단이미지</label></td>
                  				<td><input type="file" id="bc_tail_file" name="bc_tail_file" class="form-control" placeholder="게시판 하단이미지"></td>
                			</tr>
							<tr>
                  				<td><label for="bc_list_level">권한설정</label></td>
                  				<td>
									<label for="bc_list_level">목록 레벨 :</label>
									<select id="bc_list_level" name="bc_list_level">
									 <?for($i=0;$i<=9;$i++){?>
										 <option value="<?=$i?>"><?=$i?></option>
									 <?}?>
									</select><br />
									<label for="bc_read_level">읽기 레벨 :</label>
									<select id="bc_read_level" name="bc_read_level">
									 <?for($i=0;$i<=9;$i++){?>
										 <option value="<?=$i?>"><?=$i?></option>
									 <?}?>
									</select><br />
									<label for="bc_write_level">쓰기 레벨 :</label>
									<select id="bc_write_level" name="bc_write_level">
									 <?for($i=0;$i<=9;$i++){?>
										 <option value="<?=$i?>"><?=$i?></option>
									 <?}?>
									</select><br />
									<label for="bc_reply_level">답글 레벨 :</label>
									<select id="bc_reply_level" name="bc_reply_level">
									 <?for($i=0;$i<=9;$i++){?>
										 <option value="<?=$i?>"><?=$i?></option>
									 <?}?>
									</select><br />
									<label for="bc_comment_level">댓글 레벨 :</label>
									<select id="bc_comment_level" name="bc_comment_level">
									 <?for($i=0;$i<=9;$i++){?>
										 <option value="<?=$i?>"><?=$i?></option>
									 <?}?>
									</select>
				  				</td>
                			</tr>
							<tr>
                  				<td><label for="bc_admin">게시판 관리자ID</label></td>
                  				<td><input type="text" id="bc_admin" name="bc_admin" style="ime-mode:inactive" value="<?=$_SESSION['user_id']?>" class="form-control" placeholder="게시판 관리자ID" required></td>
                			</tr>
							<tr>
                  				<td><label for="bc_use_file">파일 업로드 사용</label></td>
                  				<td><input type="checkbox" id="bc_use_file" name="bc_use_file" value="1" title="파일 업로드 사용">사용</td>
                			</tr>
							<tr>
                  				<td><label for="bc_use_secret">비밀글 사용</label></td>
                  				<td><input type="checkbox" id="bc_use_secret" name="bc_use_secret" value="1" title="비밀글 사용">사용</td>
                			</tr>
							<tr>
                  				<td><label for="bc_use_reply">답글 사용</label></td>
                  				<td><input type="checkbox" id="bc_use_reply" name="bc_use_reply" value="1" title="답글 사용">사용</td>
                			</tr>
							<tr>
                  				<td><label for="bc_use_comment">댓글 사용</label></td>
                  				<td><input type="checkbox" id="bc_use_comment" name="bc_use_comment" value="1" title="댓글 사용">사용</td>
                			</tr>
              			</tbody>
               		</table>
               		<table class="table table-striped">
						<tr>
							<td>
								<button class="btn btn-lg btn-primary btn-block" type="submit">게시판생성</button>
							</td>
							<td>
								<button class="btn btn-lg btn-info btn-block" type="button" onclick="pageGo('admin_index','view/admin/board','boardList','','','1');">뒤로가기</button>
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