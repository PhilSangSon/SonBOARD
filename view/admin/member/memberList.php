<?php
// 페이지 변수 설정
$page = isset($_REQUEST['page'])?$_REQUEST['page']:1;
// 한 페이지에 보일 글 수
$page_row = 10;
// 한줄에 보여질 페이지 수
$page_scale = 10;
// 페이징을 출력할 변수 초기화
$paging_str = "";

// 전체 게시판 갯수 알아내기
$sql = "select count(*) as cnt from bd__member where 1";
$total_count = sql_total($sql);
// 페이지 출력 내용 만들기
$paging_str = paging($page, $page_row, $page_scale, $total_count, "section=view/admin/member&nowpage=memberList");

// 시작 열을 구함
$from_record = ($page - 1) * $page_row;
// 글목록 구하기
$query = "select * from bd__member where 1 order by m_idx desc limit ".$from_record.", ".$page_row;
$data = sql_list($query);

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
                    	<i class="fa fa-users"></i> 회원 목록
                	</li>
            	</ol>
        	</div>
    	</div>
        <!-- /.row -->
        
        <div class="row">
       		<div class="col-lg-12">
         		<h2>회원 리스트</h2>
              	<div class="table-responsive">
               		<table class="table table-bordered table-hover">
                		<thead>
                        	<tr>
                       			<th>번호</th>
                         		<th>아이디</th>
                         		<th>이름</th>
                           		<th>레벨</th>
                    		</tr>
               			</thead>
                  		<tbody>
                  	<?
                  		if($total_count > 0){
                  			for($i=0;$i<count($data);$i++){
                  	?>
                    		<tr>
                           		<td><?=($total_count - (($page -1) * $page_row) - $i)?></td>
                           		<td><a href="javascript:;" onclick="pageGo('admin_index', 'view/admin/member', 'memberModify', '', '<?=$data[$i]['m_idx']?>', '<?=$page?>');"><?=$data[$i]['m_id']?></a></td>
                        		<td><a href="javascript:;" onclick="pageGo('admin_index', 'view/admin/member', 'memberModify', '', '<?=$data[$i]['m_idx']?>', '<?=$page?>');"><?=$data[$i]['m_name']?></a></td>
                          		<td><?=memberLevelView($data[$i]['m_level'])?></td>
                         	</tr>
                   	<?
                  			}
                  		}else{
                  	?>
                  			<tr><td colspan="4" style="text-align:center">회원이 한명도 없습니다.</td></tr>
                  	<?
                  		}
                   	?>
                   			<tr><td colspan="4" style="text-align:center"><?=$paging_str?></td></tr>
                   			<tr>
                   				<td colspan="4" style="text-align:center">
                   					<button type="button" class="btn btn-primary btn-block" onclick="pageGo('admin_index', 'view/admin/member', 'memberInsert', '', '', '');">회원등록</button>
                   				</td>
                   			</tr>
                    	</tbody>
               		</table>
              	</div>
			</div>
		</div>
		<!-- /.row -->
		
	</div>
	
</div>