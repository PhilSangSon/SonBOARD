<?php
$page = isset($_REQUEST['page'])?$_REQUEST['page']:1;
$nyear = isset($_REQUEST['nyear'])?$_REQUEST['nyear']:date('Y');
$nmonth = isset($_REQUEST['nmonth'])?$_REQUEST['nmonth']:date('m');
$nday = isset($_REQUEST['nday'])?$_REQUEST['nday']:date('d');
$eyear = isset($_REQUEST['eyear'])?$_REQUEST['eyear']:date('Y');
$emonth = isset($_REQUEST['emonth'])?$_REQUEST['emonth']:date('m');
$eday = isset($_REQUEST['eday'])?$_REQUEST['eday']:date('d');
$RF_SEARCH = isset($_REQUEST['RF_SEARCH'])?$_REQUEST['RF_SEARCH']:"";
include $_SERVER['DOCUMENT_ROOT'].'/WebLog/engine.php';
?>
<div id="page-wrapper">

 	<div class="container-fluid">

    	<!-- Page Heading -->
        <div class="row">
        	<div class="col-lg-12">
            	<h1 class="page-header">
                	키워드검색 접속통계
                </h1>
                <ol class="breadcrumb">
                   	<li>
                    	<i class="fa fa-dashboard"></i>  <a href="admin_index.php">홈</a>
                    </li>
               		<li class="active">
                    	<i class="fa fa-bar-chart-o"></i> 키워드검색 접속통계
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
		    	<input type='hidden' name='nowpage' id='nowpage' value='keywordSearchStats'/>
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
									<select name="nday">
									<?php 
									for($i=1;$i<=31;$i++){
										$j = sprintf('%02d',$i);
										$slt = $j == $nday ? ' selected' : '';
										echo '<option value="'.$j.'" '.$slt.'>'.$j;
									}
									?>
									</select>
									일
									~
									<select name="eyear">
									<?php 
									for($i=date('Y')-5;$i<=date('Y');$i++){
										$slt = $i == $eyear ? ' selected' : '';
										echo '<option value="'.$i.'" '.$slt.'>'.$i;
									}
									?>
									</select>
									년
									<select name="emonth">
									<?php 
									for($i=1;$i<=12;$i++){
										$j = sprintf('%02d',$i);
										$slt = $j == $emonth ? ' selected' : '';
										echo '<option value="'.$j.'" '.$slt.'>'.$j;
									}
									?>
									</select>
									월
									<select name="eday">
									<?php 
									for($i=1;$i<=31;$i++){
										$j = sprintf('%02d',$i);
										$slt = $j == $eday ? ' selected' : '';
										echo '<option value="'.$j.'" '.$slt.'>'.$j;
									}
									?>
									</select>
									일
									<select name="RF_SEARCH">
										<option value=''>-검색엔진별</option>
									<?php for($i = 1; $i < sizeof($ENSET); $i++){
										$slt = $i == $RF_SEARCH ? ' selected' : '';
										$ENURL = explode(',' , $ENSET[$i]);
										echo '<option value="'.$i.'" '.$slt.'>'.$ENURL[0];
									}?>
		
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
                       			<th>키워드</th>
                         		<th>접속수</th>
                         		<th>비율</th>
                           		<th>그래프</th>
                    		</tr>
               			</thead>
                  		<tbody>
<?php 
if($RF_SEARCH!=""){
	$s_query = "AND RF_SEARCH='".$RF_SEARCH."'";
}else{
	$s_query = "";
}

//	$TOT   = mysql_fetch_array(mysql_query("SELECT count(RF_DATE) FROM feelmoa_referer WHERE RF_DATE LIKE '".$nyear.$nmonth.$nday."%' AND RF_KEYWORD <> '' $s_query"));
	$TOT   = mysqli_fetch_array(mysqli_query($connect, "SELECT count(RF_DATE) FROM feelmoa_referer WHERE  LEFT( rf_date, 8 ) BETWEEN '{$nyear}{$nmonth}{$nday}' and'{$eyear}{$emonth}{$eday}' AND RF_KEYWORD <> '' $s_query"));
	
$total = 0;
//$res= mysql_query("SELECT RF_KEYWORD,count(RF_DATE) AS SID FROM feelmoa_referer WHERE RF_DATE LIKE '".$nyear.$nmonth.$nday."%' AND RF_KEYWORD <> '' $s_query  GROUP BY RF_KEYWORD ORDER BY SID DESC");
$res= mysqli_query($connect, "SELECT RF_KEYWORD,count(RF_DATE) AS SID FROM feelmoa_referer WHERE  LEFT( rf_date, 8 ) BETWEEN '{$nyear}{$nmonth}{$nday}' and'{$eyear}{$emonth}{$eday}' AND RF_KEYWORD <> '' $s_query  GROUP BY RF_KEYWORD ORDER BY SID DESC");

while($KEY =mysqli_fetch_array($res)){

	$per   = @round(($KEY[1]/$TOT[0])*100,1);
	$ENURL = explode(',' , $v);
	$total += $KEY[1];
?>
							<tr>
								<td style="width:20%"><?=$KEY['RF_KEYWORD']?></td>
								<td><strong><?php echo number_format($KEY[1]);?></strong></td>
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
								<td><strong><?php echo number_format($total);?></strong></td>
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