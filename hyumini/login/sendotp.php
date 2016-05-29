<?php
	require("../db.php");
	/*
	 *	Author: ������
	 *	@Description
	 *	�н����带 �ؾ������ ��, forgotpw.php���� ajax request�� ������,
	 *	otp�� �����Ͽ� �Ѿ���Ϸ� ������ �����ϴ�.
	 *  otp ���̺� �й��� otp�� �����մϴ�.
	 *	ù �α��ε� ���� �й��� ��й�ȣ�� ã�� ���� �� �������� ȣ������ �ʰ� forgotpw.php���� �ٷ� ó���մϴ�.
	 *  (sendotp.php���� ���� ���̶�� ���⿡ ��ƽ��ϴ�.)
	 *
	 *	@Param(POST)
	 *	id: forgotpw.php���� �Է¹��� ID Ȥ�� �й�
	 *
	 *	@Return(JSON)
	 *	resultCode: ������ �����ϴ�.			
	 *	OTP successfully sent	:  1	200
	 *	Sending OTP failed		:  0	404
	 *	Exception/Error			: -1	400
	 */

	//7�ڸ� OTP ���� �Լ�
	function generateOTP(){
		$alnum = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$alnum = str_shuffle($alnum);
		$otp = substr($alnum, rand(0, 12), 7);
		$otp = str_shuffle($otp);
//		echo $otp;
		return $otp;
	}
	
	//OTP�� ���Ϸ� ������ �Լ�.
	function sendOTP($mailto, $otp){
		$subject =	"OTP from HYU �� mini.";
		$message =	"HYU �� mini OTP: ".$otp;
		$headers =	'From: hyumini@hanyang.ac.kr' . "\r\n" .
					'Reply-To: hyumini@hanyang.ac.kr' . "\r\n" .
					'X-Mailer: PHP/' . phpversion();
		return mail($mailto, $subject, $message, $headers);
	}

	http_response_code(400);
	header("Content-type: application/json");
	$err = json_encode(Array("resultCode"=>-1));
	if(!isset($_POST["id"])){
		echo $err;
		exit;
	}
	$id = quote($_POST["id"]);
	$table = "User";
	$clause = "WHERE id=".$id." OR SID=".$id;
	$cnt = counts($table, $clause);

	//���ڵ尡 ������ �������� �ʴ� ID
	if($cnt==0){
		http_response_code(404);
		echo json_encode(Array("resultCode"=>0));
		exit;
	}else if($cnt!=1){//1���� �ƴϸ� ���� ���������� ���
		echo $err;
		exit;
	}

	$email = selectOne($table, "email", $clause);
	$sid = selectOne($table, "SID", $clause);

	$table = "OTP";
	$clause = "WHERE SID=".$sid;
	$cnt = counts($table, $clause);
	$otp = generateOTP();
	$expire = date("Y-m-d H:i:s", time()+1800);
	if($cnt==0){
		$params = Array($sid, pwd($otp), $expire);
		if(insert($table, $params)==-1){
			echo $err;
			exit;
		}
	}else if($cnt==1){
		$set = Array("OTP"=>pwd($otp), "expire"=>$expire);
		if(update($table, $set, $clause)!=1){
			echo $err;
			exit;
		};
	}else{
		echo $err;
		exit;
	}
	if(sendOTP($email, $otp)){
		http_response_code(200);
		echo json_encode(Array("resultCode"=>1));
	}else{
		http_response_code(500);
		echo $err;
	}
	
?>