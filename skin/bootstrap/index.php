<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="MyProject 관리자">
    <meta name="author" content="손필상">
    <link rel="icon" href="../../favicon.ico">

    <title><?=$_cfg['SiteTitle']?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?=$_cfg['skin_path']?>css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?=$_cfg['skin_path']?>css/dashboard.css" rel="stylesheet">
    <!-- offcanvas -->
    <link href="<?=$_cfg['skin_path']?>css/offcanvas.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="<?=$_cfg['skin_path']?>js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="<?=$_cfg['skin_path']?>js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="<?=$_cfg['skin_path']?>js/html5shiv.min.js"></script>
      <script src="<?=$_cfg['skin_path']?>js/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
  <nav class="navbar navbar-inverse navbar-fixed-top">
	  <div class="container-fluid">
		<div class="navbar-header">
		  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		  </button>
		  <a class="navbar-brand" href="<?=$_cfg['admin_path']?>"><?=$_cfg['projectName']?></a>
		</div>
		<div id="navbar" class="navbar-collapse collapse">
		  <ul class="nav navbar-nav navbar-right">
			<li><a href="<?=$_cfg['admin_path']?>">관리자</a></li>
			<li><a href="<?=$_cfg['base_path']?>">사이트</a></li>
			<li><a href="./setup.php">설정</a></li>
			<li><a href="./logout.php">로그아웃</a></li>
		  </ul>
		<!-- 검색  
		  <form class="navbar-form navbar-right">
			<input type="text" class="form-control" placeholder="Search...">
		  </form>
		-->
		</div>
	  </div>
	</nav>
	
	<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="<?=$_cfg['skin_path']?>js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="<?=$_cfg['skin_path']?>js/holder.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="<?=$_cfg['skin_path']?>js/ie10-viewport-bug-workaround.js"></script>
    <!-- sidebar toggle js -->
    <script src="<?=$_cfg['skin_path']?>js/offcanvas.js"></script>
    <!-- 로컬 js -->
    <script src="<?=$_cfg['skin_path']?>js/myproject.js"></script>
    
	<link href="<?=$_cfg['skin_path']?>css/bootstrap-datepicker3.min.css" rel="stylesheet">
	<script src="<?=$_cfg['skin_path']?>js/bootstrap-datepicker.min.js"></script>
	<script src="<?=$_cfg['skin_path']?>locales/bootstrap-datepicker.kr.min.js" charset="UTF-8"></script>

    <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
    <script>
        (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
        function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
        e=o.createElement(i);r=o.getElementsByTagName(i)[0];
        e.src='//www.google-analytics.com/analytics.js';
        r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
        ga('create','UA-XXXXX-X','auto');ga('send','pageview');
    </script>
  </body>
</html>