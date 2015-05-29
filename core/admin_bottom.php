	<div style="margin-top:0px;padding:25px;border-top:1px solid silver;background-color:#ffffff">
<?include './include/footer.php';?>
	</div>
</div>
    <!-- /#wrapper -->
	<form name='PageForm' id='PageForm' method='post' onsubmit='return false;'>
    	<input type='hidden' name='section' id='section'/>
    	<input type='hidden' name='nowpage' id='nowpage'/>
    	<input type='hidden' name='mode' id='mode'/>
    	<input type='hidden' name='idx' id='idx'/>
    	<input type='hidden' name='page' id='page'/>
    </form>
    
    <form name='PageDateForm' id='PageDateForm' method='post' onsubmit='return false;'>
    	<input type='hidden' name='section' id='section'/>
    	<input type='hidden' name='nowpage' id='nowpage'/>
    	<input type='hidden' name='mode' id='mode'/>
    	<input type='hidden' name='idx' id='idx'/>
    	<input type='hidden' name='page' id='page'/>
    	<input type='hidden' name='nyear' id='nyear'/>
    	<input type='hidden' name='nmonth' id='nmonth'/>
    	<input type='hidden' name='nday' id='nday'/>
    </form>
    
    <!-- jQuery -->
    <script src="<?=$_cfg['skin_path']?>js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?=$_cfg['skin_path']?>js/bootstrap.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="<?=$_cfg['skin_path']?>js/plugins/morris/raphael.min.js"></script>
    <script src="<?=$_cfg['skin_path']?>js/plugins/morris/morris.min.js"></script>
    <script src="<?=$_cfg['skin_path']?>js/plugins/morris/morris-data.js"></script>

    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="<?=$_cfg['skin_path']?>js/holder.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="<?=$_cfg['skin_path']?>js/ie10-viewport-bug-workaround.js"></script>
    <!-- Custom js -->
    <script src="<?=$_cfg['skin_path']?>js/myproject.js"></script>
    
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