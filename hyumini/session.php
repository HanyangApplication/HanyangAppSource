<?php
	session_start();

	/* 
	 * @Author
	 * Author: 안윤근
	 * 
	 * @Description
	 * studentInfo가 세션에 있다면 제공합니다.
	 * 아니라면 없음을 알리기 위해 http response code 400을 보냅니다.
	 * 로그인을 하고나면 studentInfo가 세션에 세팅됩니다.
	 * 
	 * @Return
	 * studentInfo: checklogin.php에서 설정한 세션정보입니다.
	 * resultCode: 결과 코드입니다. 다음과 같습니다.
	 *							http response code
	 * Error/Exception => -1		400
	 * Success	=>	1				200
	 * 
	 */

	header("Content-type: application/json");
	if(!isset($_SESSION["studentInfo"])) {
		http_response_code(400);
		echo json_encode(Array("studentInfo"=>null, "resultCode"=>-1));
		session_destroy();
		exit;
	}else if(isset($_GET["mode"]) && $_GET["mode"]=="destroy"){
		session_destroy();
	}else{
		http_response_code(200);
		echo json_encode(Array("studentInfo"=>$_SESSION["studentInfo"], "resultCode"=>1));
	}
?>