<!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
<div class="collapse navbar-collapse navbar-ex1-collapse">
	<ul class="nav navbar-nav side-nav">
    	<li <?=menuClassActive($nowpage, "")?>>
        	<a href="./admin_index.php"><i class="fa fa-fw fa-dashboard"></i> 관리자</a>
    	</li>
   		<li <?=menuClassActive($nowpage, "boardList")?><?=menuClassActive($nowpage, "boardModify")?>>
     		<a href="javascript:;" onclick="pageGo('admin_index','view/admin/board','boardList','','','1');"><i class="fa fa-fw fa-table"></i> 게시판</a>
    	</li>
    	<li <?=menuClassActive($nowpage, "memberList")?><?=menuClassActive($nowpage, "memberModify")?>>
       		<a href="javascript:;" onclick="pageGo('admin_index','view/admin/member','memberList','','','1');"><i class="fa fa-fw fa-users"></i> 회원</a>
   		</li>
		<li <?=menuClassActive($nowpage, "memberRegisterStats")?><?=menuClassActive($nowpage, "monthdayAccessStats")?><?=menuClassActive($nowpage, "dayweekAccessStats")?><?=menuClassActive($nowpage, "timeAccessStats")?><?=menuClassActive($nowpage, "searchSiteAccessStats")?><?=menuClassActive($nowpage, "keywordSearchStats")?>>
       		<a href="javascript:;" onclick="pageGo('admin_index','view/admin/accessStats','memberRegisterStats','','','1');"><i class="fa fa-fw fa-bar-chart-o"></i> 통계</a>
   		</li>
    	<li>
      		<a href="forms.html"><i class="fa fa-fw fa-edit"></i> 제휴상담</a>
   		</li>
	</ul>
</div>
<!-- /.navbar-collapse -->