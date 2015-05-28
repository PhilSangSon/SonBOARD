<?php
$page = isset($_REQUEST['page'])?$_REQUEST['page']:1;
$nyear = isset($_REQUEST['nyear'])?$_REQUEST['nyear']:date('Y');
$nmonth = isset($_REQUEST['nmonth'])?$_REQUEST['nmonth']:date('m');
$kind = isset($_REQUEST['kind'])?$_REQUEST['kind']:0;

$r_yoil = array("일","월","화","수","목","금","토");

$date = $nyear."-".sprintf("%02d",$nmonth);
$last = date("t",strtotime($date."-01"));
$class = "";
if($kind==0) $class =' style="display:none"';
?>
<div id="page-wrapper">

 	<div class="container-fluid">

    	<!-- Page Heading -->
        <div class="row">
        	<div class="col-lg-12">
            	<h1 class="page-header">
                	월/일자별 접속통계
                </h1>
                <ol class="breadcrumb">
                   	<li>
                    	<i class="fa fa-dashboard"></i>  <a href="admin_index.php">홈</a>
                    </li>
               		<li class="active">
                    	<i class="fa fa-bar-chart-o"></i> 월/일자별 접속통계
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
		    	<input type='hidden' name='nowpage' id='nowpage' value='monthdayAccessStats'/>
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
									<span <?=$class?> id="nmonth">
									<select name="nmonth">
									<?php 
									for($i=1;$i<=12;$i++){
										$j = sprintf('%02d',$i);
										$slt = $j == $nmonth ? ' selected' : '';
										echo '<option value="'.$j.'" '.$slt.'>'.$j;
									}
									?>
									</select>
									월</span>
									&nbsp;
									<select name="kind">
									<option value="0" <?php if($kind==0) echo ' selected';?>>월별 접속통계
									<option value="1" <?php if($kind==1) echo ' selected';?>>일자별 접속통계
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
       			<div class="table-responsive">
       				<table class="table table-bordered table-hover">
                		<thead>
                        	<tr>
                       			<th>일자</th>
                         		<th>접속수</th>
                         		<th>비율</th>
                           		<th>그래프</th>
                    		</tr>
               			</thead>
                  		<tbody>
<?php
//  월별 접속통계
if($kind==0){
	$TOT = mysqli_fetch_array(mysqli_query($connect, "SELECT sum(CT_HIT) FROM feelmoa_count WHERE CT_DATE LIKE '".$nyear."%'"));
	
	for ($i=1;$i<=12;$i++){
		$o = sprintf('%02d', $i);
		$NUM   = mysqli_fetch_array(mysqli_query($connect, "SELECT sum(CT_HIT) FROM feelmoa_count WHERE CT_DATE LIKE '".$nyear.$o."%'"));
		$per   = @round(($NUM[0]/$TOT[0])*100,2);
	
		$bg = $i == 12 ? '#3566a8' : '#dbdbdb';
?>
							<tr>
								<td style="width:20%"><?=$nyear?>년 <?=$o?>월</td>
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
<?php
}

// 일자별 접속통계
if($kind==1){
	$TOT = mysqli_fetch_array(mysqli_query($connect, "SELECT sum(CT_HIT) FROM feelmoa_count WHERE CT_DATE LIKE '".$nyear.$nmonth."%'"));
	
	for ($i=1;$i<=$last;$i++){
		$o = sprintf('%02d', $i);
		$NUM   = mysqli_fetch_array(mysqli_query($connect, "SELECT sum(CT_HIT) FROM feelmoa_count WHERE CT_DATE = '".$nyear.$nmonth.$o."'"));
		$per   = @round(($NUM[0]/$TOT[0])*100,2);
		$bg = $i == $last ? '#3566a8' : '#dbdbdb';
?>
							<tr>
								<td style="width:20%"><?=$nyear?>년 <?=$nmonth?>월 <?=$o?>일</td>
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
<?php
}
?>
                  		</tbody>
                  	</table>
       			</div>
       		</div>
       	</div>
       	<!-- /.row -->
       	
	</div>

</div>