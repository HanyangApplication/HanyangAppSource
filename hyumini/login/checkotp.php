<?php
	require("../db.php");
	
	/*
	 *	Author: ������
	 *	@Description
	 *	inputotp.php���� �й�(ID)�� ����ڿ��� �Է¹��� OTP�� ajax request�� ������,
	 *	DB���� �ش� �й�(ID)�� ����� OTP�� ��ȸ�Ͽ�,
	 *	1. expired Date�� �������� Ȯ���ϰ�
	 *	2. OTP�� ��ġ�Ǵ��� Ȯ���մϴ�.
	 *	3. 1,2�� ��� �����Ѵٸ� ���̺��� �ش� OTP ���ڵ带 �����մϴ�.
	 *
	 *	@Param(GET)
	 *	id: forgotpw.php���� �Է¹��� ID Ȥ�� �й�
	 *	otp: ����ڷκ��� �Է¹��� otp
	 *
	 *	@Return(JSON)
	 *	reason: ������ ����
	 *	resultCode: ������ �����ϴ�.
	 *	Matched						:  1
	 *	Not Matched	or OTP Expired	:  0
	 *	Exception/Error				: -1
	 */
	
	http_response_code(400);
	header("Content-type: application/json");
	$err = json_encode(Array("reason"=>"Exception/Error", "resultCode"=>-1));
	if(!isset($_GET["id"])){
		echo $err;
		exit;
	}
	if(!isset($_GET["otp"])){
		echo $err;
		exit;
	}
	$id = $_GET["id"];
	$inputotp = pwd($_GET["otp"]);
	
	$table = "User";
	$column = "SID";
	$clause = "WHERE id=".quote($id)." OR sid=".quote($id);
	$sid = selectOne($table,$column,$clause);

	$table = "OTP";
	$column = "*";
	$clauses = Array("WHERE"=>"SID=".quote($sid), "ORDER BY"=>"expire DESC", "LIMIT"=>1);
	$result = selectAll($table, $column, $clauses);
	//print_r($result);
	if(count($result)==0){
		echo $err;
		exit;
	}

	$result = $result[0];
	$otp = $result["OTP"];
	$expire = $result["expire"];
	$expire = DateTime::createFromFormat("Y-m-d H:i:s", $expire);
	$expire = $expire->getTimestamp();
	
	http_response_code(404);
	if((time()-$expire)>300){
		echo json_encode(Array("reason"=>"OTP already expired.","resultCode"=>0));
	}
	else if($inputotp != $otp){
//		echo $inputotp."<br/>";
//		echo $otp."<br/>";
		echo json_encode(Array("reason"=>"Incorrect OTP.","resultCode"=>0));
	}else{
		deletes($table, $clauses);
		http_response_code(200);
		echo json_encode(Array("resultCode"=>1));
	}

?>