<?php

	require("../db.php");
	
	/*
	 *	Author: ������
	 *	@Description
	 *	������� pw�� �ٲ��ݴϴ�.
	 *
	 *	@Param(POST)
	 *	id: forgotpw.php���� �Է¹��� ID Ȥ�� �й�
	 *	newPW: ����ڷκ��� �Է¹��� otp
	 *
	 *	@Return(JSON)
	 *	reason: ������ ����
	 *	resultCode: ������ �����ϴ�.
	 *											HTTP Response Code
	 *	Matched						:  1		200
	 *	Not Matched	or OTP Expired	:  0		404
	 *	Exception/Error				: -1		400/500
	 */
	
	function validation($pw){
		global $table, $clause;
		$minLen = 8;
		$id = selectOne($table, "id", $clause);
		$sid = selectOne($table, "sid", $clause);
		if($pw==$id)
			return "ID�� ������ ��й�ȣ�� ����Ͻ� �� �����ϴ�.";
		if($pw==$sid)
			return "�й��� ������ ��й�ȣ�� ����Ͻ� �� �����ϴ�.";
		if(is_numeric($pw))
			return "���ڸ����� �̷���� �н������ ����Ͻ� �� �����ϴ�.";
		if(strlen($pw)<$minLen)
			return "�ּ� ".$minLen."�ڸ��� �Ѵ� �н����带 ����ϼž� �մϴ�.";
		return null;
	}

	http_response_code(400);
	header("Content-type: application/json");
	$err = json_encode(Array("reason"=>"Exception/Error", "resultCode"=>-1));
	if(!isset($_POST["id"])){
		echo $err;
		exit;
	}
	if(!isset($_POST["newPW"])){
		echo $err;
		exit;
	}
	$id = quote($_POST["id"]);
	$pw = $_POST["newPW"];

	$table = "User";
	$clause = "WHERE id=".$id." OR SID=".$id;
	$cnt = counts($table,$clause);
	//���� ID.
	if($cnt==0){
		http_response_code(404);
		echo json_encode(Array("resultCode"=>0,"reason"=>"ID or SID is not exist."));
	}else if($cnt!=1){//ID�� �������� ����(������)
		echo $err;
	}else{
		$reason = validation($pw);
		if($reason!=null){
			http_response_code(404);
			echo json_encode(Array("reason"=>$reason, "resultCode"=>0));
		}
		else{
			$set = Array("pw"=>pwd($pw));
			$cnt = update($table,$set,$clause);
			if($cnt==1){
				http_response_code(200);
				echo json_encode(Array("resultCode"=>1,"reason"=>null));
			}else{
				echo $err;
			}
		}
	}

?>