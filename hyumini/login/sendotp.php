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
	 *	@Return(text)
	 *	Success				:  1
	 *	Failed				:  0
	 *	Exception/Error		: -1
	 */

	function generateOTP(){
		$alnum = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$alnum = str_shuffle($alnum);
		$otp = substr($alnum, 5, 12);
		$otp = str_shuffle($otp);
		return $otp;
	}

	function sendOTP($mailto, $otp){
		$subject = "HYU��mini���� ���� OTP�Դϴ�.";
		$message = "
		<html>
		<head>
			<title>".$subject."</title>
		</head>
		<body>
			<p>
				������ OTP�� ���ø����̼ǿ� �Է����ּ���: <strong>".$otp."</strong>
			</p>
			<p>
				* �� ������ �߽������Դϴ�. <br/>
				* �� ���Ͽ� ȸ������ ���ʽÿ�.<br/>
			</p>
		</body>
		</html>";
		$message = wordwrap($message, 70);
		$headers =  "From: plznoreply@hanyang.ac.kr"."\r\n".
					"Content-type: text/html; charset=iso-8859-1"."\r\n".
					"X-Mailer: PHP/".phpversion();
		mail($mailto, $subject, $message, $headers);
	}

	if(!isset($_POST["id"])){
		echo -1;
		exit;
	}
	$id = quote($_POST["id"]);
	$table = "User";
	$clause = "WHERE id=".$id." OR SID=".$id;
	$cnt = counts($table, $clause);

	//���ڵ尡 ������ �������� �ʴ� ID
	if($cnt==0){
		echo 0;
		exit;
	}else if($cnt!=1){//1���� �ƴϸ� ���� ���������� ���
		echo -1;
		exit;
	}

	$email = selectOne($table, "email", $clause);
	$sid = selectOne($table, "SID", $clause);

	$table = "OTP";
	$clause = "WHERE SID=".$sid;
	$cnt = counts($table, $clause);
	$otp = generateOTP();
	$expire = date("Y-m-d H:i:s", time()+300);
	if($cnt==0){
		$params = Array($sid, $otp, $expire);
		if(insert($table, $params)==-1){
			echo -1;
			exit;
		}
	}else if($cnt==1){
		$set = Array("OTP"=>$otp, "expire"=>$expire);
		if(update($table, $set, $clause)!=1){
			echo -1;
			exit;
		};
	}else{
		echo -1;
		exit;
	}
	sendOTP($email, $otp);
	echo 1;
	
?>