<?php
/**
 * engine.php
 * 검색엔진 및 키워드를 추출하기 위한 배열셋트
 * 임의의 사이트를 추가하려면 아래의 배열에 같은 형식으로 인수를 추가한다.
 * 배열인수 : 왼쪽부터 검색엔진명칭,도메인,검색어를넘겨주는파라미터
 */
//검색사이트의 명칭
$ENSET = array(
		"기타사이트,,,",
		"구글(한글),google.co.kr,q",
		"구글(영문),google.com,q",
		"빙,bing.search.daum.net,q",
		"네이버,naver.com,query",
		"다음,daum.net,q",
		"야후,yahoo.co.kr,p",
		"엠파스,empas.com,q",
		"네이트,nate.com,query",
		"한미르,hanmir.com,QR",
		"하나포스,hanafos.com,query",
		"드림위즈,dreamwiz.com,q",
		"랭키닷컴,rankey.com,search_word",
		"심마니,chol.com,q"
);
?>