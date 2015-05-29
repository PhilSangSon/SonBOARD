<?php
$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
// 한 페이지에 보일 글 수
$page_row = 10;
// 한줄에 보여질 페이지 수
$page_scale = 10;
// 페이징을 출력할 변수 초기화
$paging_str = "";
$nyear = isset($_REQUEST['nyear']) ? $_REQUEST['nyear'] : date('Y');
$nmonth = isset($_REQUEST['nmonth']) ? $_REQUEST['nmonth'] : date('m');
$nday = isset($_REQUEST['nday']) ? $_REQUEST['nday'] : date('d');
$RF_SEARCH = isset($_REQUEST['RF_SEARCH']) ? $_REQUEST['RF_SEARCH'] : "";
include $_SERVER['DOCUMENT_ROOT'].'/WebLog/engine.php';
function getRefererUrl($url) {
	if (!trim($url))
		return '';
	$url_exp = explode('/', $url);
	return str_replace('www.', '', $url_exp[2]);
}
function getRefererUrl1($url) {
	if (!trim($url))
		return '미경유 접속';
	$url_exp = explode('/', $url);
	return getStrCut(str_replace('www.', '', $url_exp[2]), 15, '..');
}
?>
<div id="page-wrapper">

 	<div class="container-fluid">

    	<!-- Page Heading -->
        <div class="row">
        	<div class="col-lg-12">
            	<h1 class="page-header">
                	접속로그 데이타
                </h1>
                <ol class="breadcrumb">
                   	<li>
                    	<i class="fa fa-dashboard"></i>  <a href="admin_index.php">홈</a>
                    </li>
               		<li class="active">
                    	<i class="fa fa-bar-chart-o"></i> 접속로그 데이타
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
		    	<input type='hidden' name='nowpage' id='nowpage' value='accessLogSearchStats'/>
		    	<input type='hidden' name='mode' id='mode' value=''/>
		    	<input type='hidden' name='page' id='page' value='<?=$page?>'/>
		    	<div class="table-responsive">
               		<table class="table table-bordered table-hover">
               			<tbody>
                			<tr>
                				<td>
                					<select name="nyear">
									<?php
									for ($i = date('Y') - 5; $i <= date('Y'); $i++) {
										$slt = $i == $nyear ? ' selected' : '';
										echo '<option value="'.$i.'" '.$slt.'>'.$i;
									}
									?>
									</select>
									년
									<select name="nmonth">
									<?php
									for ($i = 1; $i <= 12; $i++) {
										$j = sprintf('%02d', $i);
										$slt = $j == $nmonth ? ' selected' : '';
										echo '<option value="'.$j.'" '.$slt.'>'.$j;
									}
									?>
									</select>
									월
									<select name="nday">
									<?php
									for ($i = 1; $i <= 31; $i++) {
										$j = sprintf('%02d', $i);
										$slt = $j == $nday ? ' selected' : '';
										echo '<option value="'.$j.'" '.$slt.'>'.$j;
									}
									?>
									</select>
									일
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
                       			<th>번호</th>
                         		<th>접속일시</th>
                         		<th>접속IP</th>
                           		<th>접속경로</th>
                           		<th>검색엔진</th>
                           		<th>키워드</th>
                    		</tr>
               			</thead>
                  		<tbody>
<?php
/* $query  ="select *, date_format(RF_DATE,'%Y-%m-%d %H:%i:%s') as rdt from feelmoa_referer where RF_DATE LIKE '".$nyear.$nmonth.$nday."%' ORDER BY RF_UID DESC";

 $search="nyear=$nyear&nmonth=$nmonth&nday=$nday";
 $result = listNpage($total, $paging, $query, $connect, $search, 15, 10); */
$search="nyear=$nyear&nmonth=$nmonth&nday=$nday";
 $sql1="SET TRANSACTION ISOLATION LEVEL READ UNCOMMITTED";
 sql_query($sql1);
 $sql = "select count(*) as cnt from feelmoa_referer where RF_DATE LIKE '".$nyear.$nmonth.$nday."%' ORDER BY RF_UID DESC";
 $total_count = sql_total($sql);
 $sql2="COMMIT";
 sql_query($sql2);
 // 페이지 출력 내용 만들기
 $paging_str = pagingDate($page, $page_row, $page_scale, $total_count, "view/admin/accessStats", "accessLogSearchStats", $nyear, $nmonth, $nday);

 // 시작 열을 구함
 $from_record = ($page - 1) * $page_row;
 // 글목록 구하기
 $sql1="SET TRANSACTION ISOLATION LEVEL READ UNCOMMITTED";
 sql_query($sql1);
 $query = "select *, date_format(RF_DATE,'%Y-%m-%d %H:%i:%s') as rdt from feelmoa_referer where RF_DATE LIKE '".$nyear.$nmonth.$nday."%' ORDER BY RF_UID DESC limit ".$from_record.", ".$page_row;
//echo $query;
 $data = sql_list($query);
 $sql2="COMMIT";
 sql_query($sql2);
 
/*  $r_cnt = mysql_num_rows($result);
 $cnt = 0;
 $n = $total['num'] - ($page * $limit - $limit);
 while($RF=mysql_fetch_array($result)){
 	$cnt++;
 	$bg = $cnt == $r_cnt ? '#3566a8' : '#dbdbdb';
 
 	$ENURL = explode(',' , $ENSET[$RF['RF_SEARCH']]); */
 
if($total_count > 0){
 	for($i=0;$i<count($data);$i++){
 		$ENURL = explode(',' , $ENSET[$data[$i]['RF_SEARCH']]);
?>
							<tr>
								<td style="width:20%"><?=($total_count - (($page -1) * $page_row) - $i)?></td>
								<td><strong><?=$data[$i]['rdt']?></strong></td>
								<td><?=$data[$i]['RF_IP']?></td>
								<td><a href="<?=urldecode($data[$i]['RF_REFERER'])?>" title="<?=urldecode($data[$i]['RF_REFERER'])?>" target='_blank'><?=urldecode($data[$i]['RF_REFERER'])?></a></td>
								<td><?=$ENURL[0]?></td>
								<td>
								<?
									/* @preg_match("/".$ENURL[2]."=([^&=]+)/",$data[$i]['RF_REFERER'], $matches);			
									$CRM_ref = $matches[1];
									$str_search = urldecode($CRM_ref);
									$f_search = substr($CRM_ref, 0,1);
									if(mb_detect_encoding($str_search) == "UTF-8") { 
										echo $str = iconv("UTF-8","EUC-KR",$str_search); 
									} else {
										if ($f_search == '%')
											echo $str_search;
									} */
									echo urldecode($data[$i]['RF_KEYWORD']);
								?>
								</td>
							</tr>
<?php
 	}
}
?>
							<tr>
								<td colspan="6"><?=$paging_str?></td>
							</tr>
                  		</tbody>
                  	</table>
              	</div>
          	</div>
    	</div>
        
	</div>
	
</div>