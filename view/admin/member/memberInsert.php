<?php 
$page = isset($_REQUEST['page'])?$_REQUEST['page']:1;
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
                    	<i class="fa fa-users"></i> 회원 등록
                	</li>
            	</ol>
        	</div>
    	</div>
        <!-- /.row -->
        
        <div class="row">
       		<div class="col-lg-12">
         		<h2>회원 등록</h2>
         		<form class="form-signin" name='MyForm' id='MyForm' method='post' onsubmit='return member_insertCheck();'>
              	<input type='hidden' name='section' id='section' value='core/model'/>
		    	<input type='hidden' name='nowpage' id='nowpage' value='memberController'/>
		    	<input type='hidden' name='mode' id='mode' value='memberInsert'/>
		    	<input type="hidden" id="id_chk" name="id_chk" value="1">
              	<div class="table-responsive">
               		<table class="table table-bordered table-hover">
               			<tbody>
                			<tr>
                  				<td><label for="m_id">회원아이디</label></td>
                  				<td><input type="text" onkeyup="AjaxIdCheck(this.value);" id="m_id" name="m_id" style="ime-mode:inactive" class="form-control" placeholder="회원아이디" maxlength="12" required autofocus><input type="text" id="OutputId" style="width:100%" readonly="readonly"/></td>
                			</tr>
							<tr>
                  				<td><label for="m_name">회원이름</label></td>
                  				<td><input type="text" id="m_name" name="m_name" style="ime-mode:active" class="form-control" placeholder="회원이름" maxlength="30" required></td>
                			</tr>
							<tr>
                  				<td><label for="m_pass">비밀번호</label></td>
                  				<td><input type="text" id="m_pass" name="m_pass" style="ime-mode:inactive" class="form-control" placeholder="비밀번호" maxlength="30" required></td>
                			</tr>
							<tr>
                  				<td><label for="m_passRe">비밀번호 확인</label></td>
                  				<td><input type="text" id="m_passRe" name="m_passRe" style="ime-mode:inactive" class="form-control" placeholder="비밀번호" maxlength="30" required></td>
                			</tr>
							<tr>
                  				<td><label for="m_level">레벨</label></td>
                  				<td>
									<select id="m_level" name="m_level">
										<option value="0">대기회원</option>
										<option value="1">일반회원</option>
										<option value="2">정회원</option>
										<option value="9">관리자</option>
										<!-- <option value="99">최고관리자</option> -->
									</select>
				  				</td>
                			</tr>
							<tr>
                  				<td><label for="m_stat">상태</label></td>
                  				<td>
									<select id="m_stat" name="m_stat">
										<option value="Y">정상</option>
										<option value="D">탈퇴</option>
										<option value="S">휴면</option>
										<option value="A">관심</option>
										<option value="V">VIP</option>
									</select>
				  				</td>
                			</tr>
              			</tbody>
               		</table>
               		<table class="table table-striped">
						<tr>
							<td>
								<button class="btn btn-lg btn-primary btn-block" type="submit">회원등록</button>
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