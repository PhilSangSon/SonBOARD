<?php

?>
<div class="row" style="padding-bottom:20px">
	<div class="col-lg-12">
		<div class="btn-group btn-group-justified" role="group" aria-label="...">
			<div class="btn-group" role="group">
		    	<button type="button" onclick="pageGo('admin_index','view/admin/accessStats','memberRegisterStats','','','1');" class="btn btn-default <?if($nowpage=="memberRegisterStats"){echo "active";}?>">회원가입</button>
		  	</div>
		  	<div class="btn-group" role="group">
		    	<button type="button" onclick="pageGo('admin_index','view/admin/accessStats','monthdayAccessStats','','','1');" class="btn btn-default <?if($nowpage=="monthdayAccessStats"){echo "active";}?>">월/일자별 접속</button>
		  	</div>
		  	<div class="btn-group" role="group">
		    	<button type="button" onclick="pageGo('admin_index','view/admin/accessStats','dayweekAccessStats','','','1');" class="btn btn-default <?if($nowpage=="dayweekAccessStats"){echo "active";}?>">요일별 접속</button>
		  	</div>
		  	<div class="btn-group" role="group">
		    	<button type="button" onclick="pageGo('admin_index','view/admin/accessStats','timeAccessStats','','','1');" class="btn btn-default <?if($nowpage=="timeAccessStats"){echo "active";}?>">시간별 접속</button>
		  	</div>
		  	<div class="btn-group" role="group">
		    	<button type="button" onclick="pageGo('admin_index','view/admin/accessStats','searchSiteAccessStats','','','1');" class="btn btn-default <?if($nowpage=="searchSiteAccessStats"){echo "active";}?>">검색사이트 접속</button>
		  	</div>
		</div>
		<div class="btn-group btn-group-justified" role="group" aria-label="...">
			<div class="btn-group" role="group">
		    	<button type="button" onclick="pageGo('admin_index','view/admin/accessStats','keywordSearchStats','','','1');" class="btn btn-default <?if($nowpage=="keywordSearchStats"){echo "active";}?>">키워드검색 접속</button>
		  	</div>
		  	<div class="btn-group" role="group">
		    	<button type="button" onclick="pageGo('admin_index','view/admin/accessStats','accessLogSearchStats','','','1');" class="btn btn-default <?if($nowpage=="accessLogSearchStats"){echo "active";}?>">접속로그 데이터</button>
		  	</div>
		</div>
	</div>
</div>
<!-- /.row -->