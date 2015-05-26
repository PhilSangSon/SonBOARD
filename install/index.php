<?php
/**
 * 설치데이터 입력파일
 * @author 손필상
 * @since 2015-05-22
 */
if (file_exists("./config/dbcon.php")) {
?>
     <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
     <script>
     alert("이미 설치가 되어 있습니다.");
     location.replace("../index.php");
     </script>
<?
	exit;
}
// 게시판의 최상단 디렉토리가 쓰기가능인지 검사
if (!is_writeable("..")) {
?>
    <html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title></title>
    </head>
    <script>
        alert("최상위 디렉토리의 퍼미션을 707 이나 777 로 변경하여 주세요.");
    </script>
    <body>
    최상위 디렉토리의 퍼미션을 707 이나 777 로 변경하여 주세요.
    </body>
    </html>
    <?
	exit;
}
?>
<!DOCTYPE html>
<html lang="ko">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 위 3개의 메타 태그는 *반드시* head 태그의 처음에 와야합니다; 어떤 다른 콘텐츠들은 반드시 이 태그들 *다음에* 와야 합니다 -->
    <title>SonBOARD 설치</title>

    <!-- 부트스트랩 -->
    <link href="../skin/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE8 에서 HTML5 요소와 미디어 쿼리를 위한 HTML5 shim 와 Respond.js -->
    <!-- WARNING: Respond.js 는 당신이 file:// 을 통해 페이지를 볼 때는 동작하지 않습니다. -->
    <!--[if lt IE 9]>
      <script src="../skin/bootstrap/js/html5shiv.min.js"></script>
      <script src="../skin/bootstrap/js/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="container">
		<div class="row">
			<div class="col-lg-12" style="padding-top:20px">
				<form class="form-signin" name='MyForm' id='MyForm' method='post' onsubmit='return false;'>
					<div class="panel panel-default">
	  				<!-- Default panel contents -->
	  					<div class="panel-heading">MySQL (MariaDB) 정보</div>
	  						<div class="panel-body">
	    					<p>웹호스팅 업체 또는 시스템 관리자에게 문의해주세요</p>
	  					</div>
	
		  				<!-- List group -->
		  				<ul class="list-group">
		    				<li class="list-group-item">
		    					<input type="text" id="host" name="host" style="ime-mode:inactive" class="form-control" placeholder="127.0.0.1" maxlength="20" required autofocus>
		    					<label for="host">호스트명</label>
		    				</li>
		    				<li class="list-group-item">
		    					<input type="text" id="user" name="user" style="ime-mode:inactive" class="form-control" placeholder="DB 사용자 ID" maxlength="30" required>
		    					<label for="user">사용자 ID</label>
		    				</li>
		    				<li class="list-group-item">
		    					<input type="text" id="pass" name="pass" style="ime-mode:inactive" class="form-control" placeholder="DB 비밀번호" maxlength="30" required>
		    					<label for="pass">비밀번호</label>
		    				</li>
		    				<li class="list-group-item">
		    					<input type="text" id="db_name" name="db_name" style="ime-mode:inactive" class="form-control" placeholder="데이터베이스명" maxlength="30" required>
		    					<label for="db_name">DB명</label>
		    				</li>
		  				</ul>
					</div>
					<div class="panel panel-default" style="margin-top:20px">
	  				<!-- Default panel contents -->
	  					<div class="panel-heading">관리자 정보</div>
	  						<div class="panel-body">
	    					<p>운영하게될 관리자 정보입력폼</p>
	  					</div>
	
		  				<!-- List group -->
		  				<ul class="list-group">
		    				<li class="list-group-item">
		    					<input type="text" id="admin_id" name="admin_id" style="ime-mode:inactive" class="form-control" placeholder="관리자 아이디" maxlength="12" required>
		    					<label for="admin_id">아이디</label>
		    				</li>
		    				<li class="list-group-item">
		    					<input type="text" id="admin_name" name="admin_name" style="ime-mode:active" class="form-control" placeholder="관리자 이름" maxlength="30" required>
		    					<label for="admin_name">이름</label>
		    				</li>
		    				<li class="list-group-item">
		    					<input type="text" id="admin_pass" name="admin_pass" style="ime-mode:inactive" class="form-control" placeholder="관리자 비밀번호" maxlength="30" required>
		    					<label for="admin_pass">비밀번호</label>
		    				</li>
		  				</ul>
					</div>
					
					<button type="button" onclick="installCheck();" class="btn btn-primary btn-lg btn-block">설치하기</button>
					
				</form>
			</div>
		</div>
		<div style="margin-top:20px;padding-top:20px;border-top:1px solid silver">
<?include '../include/footer.php';?>
		</div>
	</div>
	
    <!-- jQuery (부트스트랩의 자바스크립트 플러그인을 위해 필요합니다) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- 모든 컴파일된 플러그인을 포함합니다 (아래), 원하지 않는다면 필요한 각각의 파일을 포함하세요 -->
    <script src="../skin/bootstrap/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../skin/bootstrap/js/ie10-viewport-bug-workaround.js"></script>
    <!-- Custom js -->
    <script src="../skin/bootstrap/js/myproject.js"></script>
  </body>
</html>