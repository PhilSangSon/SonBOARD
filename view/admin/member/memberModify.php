<?php
$page = isset($_REQUEST['page'])?$_REQUEST['page']:1;
$m_idx = isset($_REQUEST['idx']) ? $_REQUEST['idx'] :"";
// 회원 데이터 불러오기
$sql = "select m_idx, m_id, m_name, AES_DECRYPT(UNHEX(m_pass), 'thsvlftkdWkd') As m_pass, m_level, m_stat, m_regdate from bd__member where m_idx = '".$m_idx."'";
$data = sql_fetch($sql);
if(!$data['m_idx']){
	PageAlert("없는 회원입니다.", "view/admin/member", "memberList", $page);
}
?>
<div id="page-wrapper">

 	<div class="container-fluid">

    	<!-- Page Heading -->
        <div class="row">
        	<div class="col-lg-12">
            	<h1 class="page-header">
                	회원 관리
                </h1>
                <ol class="breadcrumb">
                   	<li>
                    	<i class="fa fa-dashboard"></i>  <a href="admin_index.php">홈</a>
                    </li>
               		<li class="active">
                    	<i class="fa fa-users"></i> 회원 수정
                	</li>
            	</ol>
        	</div>
    	</div>
        <!-- /.row -->
        
        <div class="row">
       		<div class="col-lg-12">
         		<h2>회원 입력</h2>
         		<form class="form-signin" name='MyForm' id='MyForm' method='post' onsubmit='return member_modifyCheck();'>
              	<input type='hidden' name='section' id='section' value='core/model'/>
		    	<input type='hidden' name='nowpage' id='nowpage' value='memberController'/>
		    	<input type='hidden' name='mode' id='mode' value='memberModify'/>
		    	<input type='hidden' name='m_idx' id='m_idx' value='<?=$m_idx?>'/>
		    	<input type='hidden' name='page' id='page' value='<?=$page?>'/>
              	<div class="table-responsive">
               		<table class="table table-bordered table-hover">
               			<tbody>
                			<tr>
                  				<td><label for="m_id">회원아이디</label></td>
                  				<td><?=$data['m_id']?></td>
                			</tr>
							<tr>
                  				<td><label for="m_name">회원이름</label></td>
                  				<td><input type="text" id="m_name" name="m_name" value="<?=$data['m_name']?>" style="ime-mode:active" class="form-control" placeholder="회원이름" maxlength="30" required autofocus></td>
                			</tr>
							<tr>
                  				<td><label for="m_pass">비밀번호</label></td>
                  				<td><input type="text" id="m_pass" name="m_pass" value="<?=$data['m_pass']?>" style="ime-mode:inactive" class="form-control" placeholder="비밀번호" maxlength="30" required></td>
                			</tr>
							<tr>
                  				<td><label for="m_level">레벨</label></td>
                  				<td>
									<select id="m_level" name="m_level">
										<option value="0" <?if($data['m_level']==0){echo "selected='selected'";}?>>대기회원</option>
										<option value="1" <?if($data['m_level']==1){echo "selected='selected'";}?>>일반회원</option>
										<option value="2" <?if($data['m_level']==2){echo "selected='selected'";}?>>정회원</option>
										<option value="9" <?if($data['m_level']==9){echo "selected='selected'";}?>>관리자</option>
										<option value="99" <?if($data['m_level']==99){echo "selected='selected'";}?>>최고관리자</option>
									</select>
				  				</td>
                			</tr>
							<tr>
                  				<td><label for="m_stat">상태</label></td>
                  				<td>
									<select id="m_stat" name="m_stat">
										<option value="Y" <?if($data['m_stat']=="Y"){echo "selected='selected'";}?>>정상</option>
										<option value="D" <?if($data['m_stat']=="D"){echo "selected='selected'";}?>>탈퇴</option>
										<option value="S" <?if($data['m_stat']=="S"){echo "selected='selected'";}?>>휴면</option>
										<option value="A" <?if($data['m_stat']=="A"){echo "selected='selected'";}?>>관심</option>
										<option value="V" <?if($data['m_stat']=="V"){echo "selected='selected'";}?>>VIP</option>
									</select>
				  				</td>
                			</tr>
							<tr>
                  				<td><label for="regdate">등록일</label></td>
                  				<td><?=$data['m_regdate']?></td>
                			</tr>
              			</tbody>
               		</table>
               		<table class="table table-striped">
						<tr>
							<td>
								<button class="btn btn-lg btn-primary btn-block" type="submit">회원수정</button>
							</td>
							<td>
								<button class="btn btn-lg btn-danger btn-block" type="button" onclick="member_delete('<?=$data['m_idx']?>');">삭제</button>
							</td>
							<td>
								<button class="btn btn-lg btn-info btn-block" type="button" onclick="pageGo('admin_index','view/admin/member','memberList','','','<?=$page?>');">뒤로가기</button>
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