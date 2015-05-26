<?php 
$c_id = isset($_COOKIE['c_id'])?$_COOKIE['c_id']:"";
?>
<div id='page-wrapper'>

	<div class='container-fluid'>

		<!-- Page Heading -->
		<div class='row'>
			<div class='col-lg-12'>
				<h1 class='page-header'>
	            	관리자 로그인
	            	<small>시스템 로그인</small>
            	</h1>
            	<ol class='breadcrumb'>
                	<li>
                		<i class='fa fa-dashboard'></i>  <a href='./admin_index.php'>관리자</a>
                	</li>
               		<li class='active'>
               			<i class='fa fa-file'></i> login
               		</li>
     			</ol>
    		</div>
		</div>
		<!-- /.row -->
		
		<div class='row'>
			<div class='col-lg-12'>
				<form class="form-signin" name='MyForm' id='MyForm' method='post' onsubmit='return loginCheck();'>
				<input type='hidden' name='section' id='section' value='core/model'/>
		    	<input type='hidden' name='nowpage' id='nowpage' value='memberController'/>
		    	<input type='hidden' name='mode' id='mode' value='login'/>
					<label for="m_id" class="sr-only">아이디</label>
			        <input type="text" id="m_id" name="m_id" value="<?=$c_id?>" class="form-control" placeholder="아이디" required autofocus>
			        <label for="m_pass" class="sr-only">비밀번호</label>
			        <input type="password" id="m_pass" name="m_pass" class="form-control" placeholder="비밀번호" required>
			        <div class="checkbox">
			          <label>
			            <input type="checkbox" name="idcheck" onclick="confirmSave(this);"
						<?
						if($c_id != ""){
							echo "checked='checked'";
						}
						?>
						> 아이디 기억하기
			          </label>
			        </div>
			        <button class="btn btn-lg btn-primary btn-block" type="submit">로그인</button>
				</form>
			</div>
		</div>

	</div>
	<!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->