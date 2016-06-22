<!DOCTYPE html>
<HTML>
	<HEAD>
	
		<meta charset="utf-8"/>
		
		<meta http-equiv="refresh" content="0; url=./weeklymenu.php"/>
		
	
	</HEAD>
</HTML>

<?php
/*
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_FAILONERROR, true);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_URL, "https://m.hanyang.ac.kr/wlife/diet/diet001002.page?campusId=02&restId=02&apiUrl%5B%5D=%2FDHSH%2FA201300004.json");
	
	
	$result = curl_exec($curl);		
	$result = preg_replace("(</div>)", "|", $result);
	$result = preg_replace("(\<(/?[^\>]+)\>)", "\n", $result);
	$result = preg_replace("#[[:space:]]{2,}#", "\n", $result);
	
	$pattern = "/중식\\n\|\\n(.*?)\\n(.*?)\\n(.*?)\\n(.*?)\\n(.*?)\\n(.*?)\\n\|/";
	//preg_match($pattern, $result, $match);
	//echo $match[5];
	preg_match_all($pattern, $result, $matches);
	// 앞이 메뉴순서, 뒤에가 요일임
	echo $matches[5][1];
	echo $result;
	*/
?>


<!--
<HTML>
	<HEAD>
	
		<meta http-equiv="refresh" content="0; url=weeklymenu.php"/>
	
	</HEAD>
</HTML>
-->