<?php
$page = isset($_REQUEST['page'])?$_REQUEST['page']:1;
$nyear = isset($_REQUEST['nyear'])?$_REQUEST['nyear']:date('Y');
$nmonth = isset($_REQUEST['nmonth'])?$_REQUEST['nmonth']:date('m');
$kind = isset($_REQUEST['kind'])?$_REQUEST['kind']:0;

$r_yoil = array("일","월","화","수","목","금","토");

$date = $nyear."-".sprintf("%02d",$nmonth);
$last = date("t",strtotime($date."-01"));

$res = mysqli_query($connect, "select count(*) as cnt from bd__member where m_level > 0");
$memTotal=mysqli_fetch_array($res);

?>
<div id="page-wrapper">

 	<div class="container-fluid">

    	<!-- Page Heading -->
        <div class="row">
        	<div class="col-lg-12">
            	<h1 class="page-header">
                	회원가입통계
                </h1>
                <ol class="breadcrumb">
                   	<li>
                    	<i class="fa fa-dashboard"></i>  <a href="admin_index.php">홈</a>
                    </li>
               		<li class="active">
                    	<i class="fa fa-bar-chart-o"></i> 기간별 회원가입통계
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
		    	<input type='hidden' name='nowpage' id='nowpage' value='memberRegisterStats'/>
		    	<input type='hidden' name='mode' id='mode' value=''/>
		    	<input type='hidden' name='page' id='page' value='<?=$page?>'/>
		    	<div class="table-responsive">
               		<table class="table table-bordered table-hover">
               			<tbody>
                			<tr>
                				<td>
	                				<select name="nyear">
									<?php 
									for($i=date('Y')-5;$i<=date('Y');$i++){
										$slt = $i == $nyear ? ' selected' : '';
										echo '<option value="'.$i.'" '.$slt.'>'.$i;
									}
									?>
									</select>
									년
									<select name="nmonth">
									<?php 
									for($i=1;$i<=12;$i++){
										$j = sprintf('%02d',$i);
										$slt = $j == $nmonth ? ' selected' : '';
										echo '<option value="'.$j.'" '.$slt.'>'.$j;
									}
									?>
									</select>
									월
									&nbsp;
									<select name="kind">
									<option value="0" <?php if($kind==0) echo ' selected';?>>일자별 가입통계
									<option value="1" <?php if($kind==1) echo ' selected';?>>요일별 가입통계
									<option value="2" <?php if($kind==2) echo ' selected';?>>시간별 가입통계
									</select>
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
<?php 
// 일자별 가입통계
if($kind==0){ 

	$search_month = $nyear."-".$nmonth;

	$queryc = "select count(*) as cnt from bd__member where	left(m_regdate,7) = '$search_month'";
	$resc = mysqli_query($connect, $queryc);
	$tn = mysqli_fetch_array($resc);
?>
       			<div class="table-responsive">
               		<table class="table table-bordered">
               			<tbody>
                			<tr>
                				<td>
                				총 <strong><?=$memTotal[0]?></strong>명, <?=$nyear?>년 <?=$nmonth?>월 가입 : <strong><?=$tn['cnt']?></strong>  명
                				</td>
                			</tr>
                		</tbody>
                	</table>
                	<table class="table table-bordered table-hover">
                		<thead>
                        	<tr>
                       			<th>일자</th>
                         		<th>가입수</th>
                         		<th>비율</th>
                           		<th>그래프</th>
                    		</tr>
               			</thead>
                  		<tbody>
<?php 
	for ($i=1;$i<=$last;$i++){
		$day = $date.'-'.sprintf("%02d",$i);
		$bg = $i == $last ? '#3566a8' : '#dbdbdb';
	
		$query = "select count(*) as cnum from bd__member where left(m_regdate,10)= '$day'";
		$res = mysqli_query($connect, $query);
		$total = 0;
		$data=mysqli_fetch_array($res);
		if($tn['cnt']<=0){
			$per = 0;
		}else{
			$per = $data['cnum']/$tn['cnt']*100;
		}
?>
							<tr>
								<td style="width:20%"><?=$day?></td>
								<td><?=number_format($data['cnum'])?></td>
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
                  		</tbody>
                  	</table>
                </div>
<?php 
}

// 요일별 가입통계
if($kind == 1){
	$query = "select DAYOFWEEK(m_regdate) rdt,count(*) as cnt from bd__member	where m_regdate like '$date%'	group by rdt";
	$res = mysqli_query($connect, $query);
	$total = 0;
	while ($data=mysqli_fetch_array($res)){
		$cnt[$data['rdt']] = $data['cnt'];
		$total += $data['cnt'];

	}
?>
				<div class="table-responsive">
               		<table class="table table-bordered">
               			<tbody>
                			<tr>
                				<td>
                				총 <strong><?=$memTotal[0]?></strong>명, <?=$nyear?>년 <?=$nmonth?>월 가입 : <strong><?=$total?></strong>  명
                				</td>
                			</tr>
                		</tbody>
                	</table>
                	<table class="table table-bordered table-hover">
                		<thead>
                        	<tr>
                       			<th>일자</th>
                         		<th>가입수</th>
                         		<th>비율</th>
                           		<th>그래프</th>
                    		</tr>
               			</thead>
                  		<tbody>
<?php
	foreach($r_yoil as $k => $v){
		if($k == 0){
			$bg ="#ff0000";
		}else if($k == 6){
			$bg ="#3566a8";
		}else{
			$bg ="#dbdbdb";
		}
		$per = @round($cnt[$k]/$total)*100;
?>
							<tr style="background-color:<?=$bg?>">
								<td style="width:20%"><?=$v?></td>
								<td><?=@number_format($cnt[$k])?></td>
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
                  		</tbody>
                  	</table>
                </div>
<?php
}

// 시간별 가입통계
if($kind == 2){
	$query = "select DATE_FORMAT( m_regdate, '%H' ) rdt, count(*) as cnt from bd__member where	m_regdate like '$date%' group by rdt";
	$res = mysqli_query($connect, $query);
	$total = 0;
	while ($data=mysqli_fetch_array($res)){
		$cnt[$data['rdt']] = $data['cnt'];
		$total += $data['cnt'];

	}
?>
				<div class="table-responsive">
               		<table class="table table-bordered">
               			<tbody>
                			<tr>
                				<td>
                				총 <strong><?=$memTotal[0]?></strong>명, <?=$nyear?>년 <?=$nmonth?>월 가입 : <strong><?=$total?></strong>  명
                				</td>
                			</tr>
                		</tbody>
                	</table>
                	<table class="table table-bordered table-hover">
                		<thead>
                        	<tr>
                       			<th>시간</th>
                         		<th>가입수</th>
                         		<th>비율</th>
                           		<th>그래프</th>
                    		</tr>
               			</thead>
                  		<tbody>
<?php
	for ($i=0;$i<=23;$i++){
		$v =sprintf("%02d",$i);
		$bg = $i == 23 ? '#3566a8' : '#dbdbdb';
	
		$per = @round($cnt[$i]/$total)*100;
?>
							<tr>
								<td style="width:20%"><?=$v?> 시</td>
								<td><?=@number_format($cnt[$i])?></td>
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
                  		</tbody>
                  	</table>
             	</div>
<?php
}
?>
       		</div>
       	</div>
        
  	</div>
  	
</div>