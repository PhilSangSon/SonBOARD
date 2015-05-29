<?php
/*
 * sys_check.php
 * -------------
 * 접속통계를 위한 OS,Agent,주요검색엔진,검색키워드 정보를 얻는다.
 */

function getOsName()
{
	global $HTTP_USER_AGENT,$OsSet1;

	$Agent = $HTTP_USER_AGENT;
	$OsNum = sizeof($OsSet1);

	for ($i = 0; $i < $OsNum; $i++)
	{
		if ($OsSet1[$i] == 'Windows')
		{
			return getOsVersion($Agent);
		}
		else {
			if (stristr($Agent,$OsSet1[$i])) return $i+5;
		}
	}
	return 0;
}
function getOsVersion($agent)
{
	$agent_exp = explode('Windows ', $agent);
	if (strstr($agent_exp[1] , 'NT 5.1')) return 1;
	if (strstr($agent_exp[1] , 'NT 5.0')) return 2;
	if (strstr($agent_exp[1] , 'ME'    )) return 3;
	if (strstr($agent_exp[1] , 'NT 4'  )) return 4;
	if (strstr($agent_exp[1] , '98'    )) return 5;
	if (strstr($agent_exp[1] , '95'    )) return 5;
	return 5;
}
function getBrowserName()
{
	global $HTTP_USER_AGENT,$BrSet1;

	$Agent = $HTTP_USER_AGENT;
	$BrNum = sizeof($BrSet1);

	for ($i = $BrNum-1; $i >= 0; $i--)
	{
		if ($BrSet1[$i] != 'MSIE')
		{
			if ($BrSet1[$i] == 'GEC')
			{
				if (stristr($Agent,'NETSCAPE')) return $i+2;
				if (stristr($Agent,'GEC')) return $i+4;
			}
			else {
				if (stristr($Agent,$BrSet1[$i])) return $i+4;
			}
		}
		else {
			return getBrowserVersion($Agent);
		}
	}
	return 0;
}
function getBrowserVersion($agent)
{
	$agent_exp = explode('MSIE ', $agent);
	if (strstr($agent_exp[1] , '6.' )) return 1;
	if (strstr($agent_exp[1] , '5.5')) return 2;
	if (strstr($agent_exp[1] , '5.' )) return 3;
	if (strstr($agent_exp[1] , '4.' )) return 4;
	return 0;
}
function getDomain($url)
{
	global $ENSET;
	$url_exp = explode('/' , $url);
	$eng_num = sizeof($ENSET);

	for ($i = 1; $i < $eng_num; $i++)
	{
		$eng_exp = explode(',' , $ENSET[$i]);
		$ser_exp = explode('.' , $eng_exp[1]);
		if (@strstr($url_exp[2] , $ser_exp[0])) return $i;
	}
	return 0;
}
function getDomain1($url)
{
	global $ENSET;
	$url_exp = explode('/' , $url);
	$eng_num = sizeof($ENSET);

	for ($i = 1; $i < $eng_num; $i++)
	{
		$eng_exp = explode(',' , $ENSET[$i]);
		$ser_exp = explode('.' , $eng_exp[1]);
		if (@strstr($url_exp[2] , $ser_exp[0])) return $eng_exp[1];
	}
	return '';
}
function getKeyword($url , $engine)
{
	global $ENSET;
	$url = iconv("UTF-8","EUC-KR",$url);
	if (!$engine)
	{
		$url_exp = explode('?' , urldecode($url));
		if (!@trim($url_exp[1])) return '';
		$que_exp = explode('&' , $url_exp[1]);
		$que_num = sizeof($que_exp);
		for ($i = 0; $i < $que_num; $i++)
		{
			$val_exp = explode('=' , $que_exp[$i]);
			if ($val_exp[1] > "z") return $val_exp[1];
		}
		return '';
	}

	$this_Que= explode(',' , $ENSET[$engine]);
	$url_exp = explode($this_Que[2].'=' , $url);
	$key_exp = explode('&' , $url_exp[1]);

	return iconv("UTF-8","EUC-KR",urldecode($key_exp[0]));
}
function getLanguage($lang)
{
	if(stristr($lang,'ko')) return 0;
	if(stristr($lang,'en')) return 1;
	if(stristr($lang,'ja')) return 2;
	if(stristr($lang,'zh')) return 3;
	if(stristr($lang,'fr')) return 4;
	if(stristr($lang,'de')) return 5;
	if(stristr($lang,'es')) return 6;
	if(stristr($lang,'it')) return 7;
	return 8;
}
//___________________________________________________________________________________________
//
extract($_GET);
extract($_POST);
extract($_SERVER);
$_SESSION['MykimsLogIp']=isset($_SESSION['MykimsLogIp'])?$_SESSION['MykimsLogIp']:$_SERVER["REMOTE_ADDR"];
$HTTP_REFERER = isset($_SERVER["HTTP_REFERER"])?$_SERVER["HTTP_REFERER"]:"";
//if($_SESSION['MykimsLogIp'] == $_SERVER["REMOTE_ADDR"]){
	// 아이피 동일
//}else{
	include $_SERVER['DOCUMENT_ROOT'].'/WebLog/engine.php';
	
	$OsSet1    = array("Windows","Linux","Mac","Irix","Sunos","Phone");
	$BrSet1    = array("MSIE","NETSCAPE","OPERA","GEC","FIREFOX");
	
	$today_date= date("Ymd");
	$RFIP      = $_SERVER["REMOTE_ADDR"];
	$RFID      = '';
	
	$RFREFERER = urlencode($HTTP_REFERER);
	$RFSEARCH  = getDomain($RFREFERER);
	$RFENGINE  = getDomain1($RFREFERER);
	$RFKEYWORD = getKeyword($RFREFERER , $RFSEARCH);
	$RFOS      = getOsName();
	$RFLANG    = getLanguage($HTTP_ACCEPT_LANGUAGE);
	$RFAGENT   = getBrowserName();
	$RFDATE    = $today_date.date("His");
	$CT_WEEK   = date("w");
	
	$CountSql = "INSERT INTO feelmoa_referer ";
	$CountSql.= "(RF_IP,RF_ID,RF_REFERER,RF_SEARCH,RF_KEYWORD,RF_OS,RF_LANG,RF_AGENT,RF_DATE) VALUES ";
	$CountSql.= "('$RFIP','$RFID','$RFREFERER','$RFSEARCH','$RFKEYWORD','$RFOS','$RFLANG','$RFAGENT','$RFDATE')";
	
	mysqli_query($connect, $CountSql);
	
	$CT_EXIS  = mysqli_fetch_array(mysqli_query($connect, "SELECT count(*) FROM feelmoa_count WHERE CT_DATE='".$today_date."'"));
	if($CT_EXIS[0]) { mysqli_query($connect, "UPDATE feelmoa_count SET CT_HIT=CT_HIT+1 WHERE CT_DATE='".$today_date."'");  }
	else { mysqli_query($connect, "INSERT INTO feelmoa_count (CT_HIT,CT_DATE,CT_WEEKDAY) VALUES ('1','".$today_date."','".$CT_WEEK."')"); }
	
	
	
	
	$MykimsLogIp = $RFIP;
	$_SESSION['MykimsLogIp']=$MykimsLogIp;
	$_SESSION['RFENGINE']   =$RFENGINE;
	$_SESSION['RFKEYWORD']  =$RFKEYWORD;
//}
?>