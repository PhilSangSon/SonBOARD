<?php
$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
$nyear = isset($_REQUEST['nyear']) ? $_REQUEST['nyear'] : date('Y');
$nmonth = isset($_REQUEST['nmonth']) ? $_REQUEST['nmonth'] : date('m');
$kind = isset($_REQUEST['kind']) ? $_REQUEST['kind'] : 0;
$startdt = isset($_REQUEST['startdt']) ? $_REQUEST['startdt'] : "";
$enddt = isset($_REQUEST['enddt']) ? $_REQUEST['enddt'] : "";

$r_yoil = array("일", "월", "화", "수", "목", "금", "토");
?>
<script type="text/javascript">
function setDate(from,to){
	document.MyForm.startdt.value = from ? from : "";
	document.MyForm.enddt.value = from ? to : "";
}
function calendarPrint(date){
	if( tagNm == "INPUT" ) eventElement.value = date;
	else eventElement.innerHTML = date;
	calendarClose();
}
function calendarClose(){
	dy_calOpen = 'n';
	thisObj.parentNode.removeChild(thisObj);
}
</script>
<div id="page-wrapper">

 	<div class="container-fluid">

    	<!-- Page Heading -->
        <div class="row">
        	<div class="col-lg-12">
            	<h1 class="page-header">
                	요일별 접속통계
                </h1>
                <ol class="breadcrumb">
                   	<li>
                    	<i class="fa fa-dashboard"></i>  <a href="admin_index.php">홈</a>
                    </li>
               		<li class="active">
                    	<i class="fa fa-bar-chart-o"></i> 요일별 접속통계
                	</li>
            	</ol>
        	</div>
    	</div>
        <!-- /.row -->
        
        <?php
		include './view/admin/accessStats/topMenu.php';
		?>
        
        <div class="row">
       		<div class="col-lg-12">
       			<form class="form-signin" name='MyForm' id='MyForm' method='post'>
              	<input type='hidden' name='section' id='section' value='view/admin/accessStats'/>
		    	<input type='hidden' name='nowpage' id='nowpage' value='dayweekAccessStats'/>
		    	<input type='hidden' name='mode' id='mode' value=''/>
		    	<input type='hidden' name='page' id='page' value='<?=$page?>'/>
		    	<div class="table-responsive">
               		<table class="table table-bordered table-hover">
               			<tbody>
                			<tr>
                				<td>
                					<div class="col-xs-2">
                						<input class="form-control input-sm" name="startdt" value="<?=$startdt?>" type="text" placeholder="시작">
                					</div>
                					<div class="col-xs-2">
                						<input class="form-control input-sm" name="enddt" value="<?=$enddt?>" type="text" placeholder="끝">
                					</div>
									<button type="button" onclick="setDate('<?=date("Ymd")?>','<?=date("Ymd")?>');" class="btn btn-default btn-xs">오늘</button>
									<button type="button" onclick="setDate('<?=date("Ymd",strtotime("-7 day"))?>','<?=date("Ymd")?>');" class="btn btn-default btn-xs">일주일</button>
									<button type="button" onclick="setDate('<?=date("Ymd",strtotime("-15 day"))?>','<?=date("Ymd")?>');" class="btn btn-default btn-xs">15일</button>
									<button type="button" onclick="setDate('<?=date("Ymd",strtotime("-1 month"))?>','<?=date("Ymd")?>');" class="btn btn-default btn-xs">한달</button>
									<button type="button" onclick="setDate('<?=date("Ymd",strtotime("-2 month"))?>','<?=date("Ymd")?>');" class="btn btn-default btn-xs">두달</button>
									<button type="button" onclick="setDate('','');" class="btn btn-default btn-xs">전체</button>
									<button type="submit" class="btn btn-primary btn-xs">검색</button>
                				</td>
                			</tr>
                		</tbody>
                	</table>
                </div>
		    	</form>
       		</div>
       	</div>
       	<!-- /.row -->
       	
       	<div class="row">
       		<div class="col-lg-12">
       			<div class="table-responsive">
       				<table class="table table-bordered table-hover">
                		<thead>
                        	<tr>
                       			<th>요일</th>
                         		<th>접속수</th>
                         		<th>비율</th>
                           		<th>그래프</th>
                    		</tr>
               			</thead>
                  		<tbody>
<?php 
if($startdt != "" && $enddt != ""){
	$s_query = " AND CT_DATE BETWEEN '$startdt' AND '$enddt'";
}else{
	$s_query = "";
}

	$TOT = mysqli_fetch_array(mysqli_query($connect, "SELECT sum(CT_HIT) FROM feelmoa_count WHERE 1 $s_query"));


foreach($r_yoil as $k => $v){
	$bg = $k == 6 ? '#3566a8' : '#dbdbdb';

	$NUM = mysqli_fetch_array(mysqli_query($connect, "SELECT sum(CT_HIT) FROM feelmoa_count WHERE CT_WEEKDAY='".$k."' $s_query"));
	$per = @round(($NUM[0]/$TOT[0])*100,1);
?>
							<tr>
								<td style="width:20%"><?=$v?></td>
								<td><strong><?php echo number_format($NUM[0]);?></strong></td>
								<td><?=number_format($per,1)?></td>
								<td>
									<div class="progress">
										<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="<?=$per?>" aria-valuemin="0" aria-valuemax="100" style="width:<?=$per?>%">
											<?=$per?>%
										</div>
									</div>
								</td>
							</tr>
<?php
}
?>
							<tr>
								<td style="width:20%"><strong>합계</strong></td>
								<td><strong><?php echo number_format($TOT[0]);?></strong></td>
								<td>100%</td>
								<td>&nbsp;</td>
							</tr>
                  		</tbody>
                  	</table>
              	</div>
          	</div>
    	</div>
        
	</div>
	
</div>