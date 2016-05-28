<?php
	require("../db.php");
	/*
	 *	Author: ������
	 *	@Description
	 *	ù �α��� ��, firstlogin.html���� ajax request�� �� �ڵ�� ������ 
	 *	���ο� id�� PW�� �����մϴ�.
	 * 
	 *	Update�̱� ������ PUT�� �°�����, �ڵ鸵�� �ټ� ���ŷӱ� ������ ���ǻ� POST�� ����մϴ�...
	 *	@Param(POST)
	 *	SID: login.html���� �Է¹޾Ҵ� �й�
	 *	newID: ���� ������ id
	 *	newPW: ���� ������ pw
	 *
	 *	@Return(JSON)
	 *	reason: ���� ���н��� �����Դϴ�.
	 *	resultCode: ���� �ڵ�� ������ �����ϴ�.
	 *  
	 *	Setting Success	  :  1	200
	 *	Setting Failed	  :  0	404
	 *	Exception/Error	  : -1	400
	 */

	/*	2a. 
	 *	���Ĺ�� ���ڸ����� �̷������ ���� id, 
	 *	���ڸ����� �̷���� id,
	 *	24�ڸ��� �Ѵ� id, 
	 *	�̹� �����ϴ� id, 
	 *	�й��� ���� pw,
	 *	ID�� ���� pw�� ��쿡 ������ error reason ����
	 *	�������̸� null ����
	 */
	function validation($id, $pw){
		global $sid, $table;
		$maxLen = 24;//ID �ִ� �ڸ���
		$minLen = 8;//ID, PW �ּ� �ڸ���
		$clause = "WHERE id=".quote($id);
		if(strlen($id)>$maxLen)
			return $maxLen."�ڸ��� �Ѵ� ID�� ����Ͻ� �� �����ϴ�.";
		if(strlen($id)<$minLen)
			return "�ּ� ".$minLen."�ڸ��� �Ѵ� ID�� ����ϼž� �մϴ�.";
		if(is_numeric($id))
			return "���ڸ����� �̷���� ID�� ����Ͻ� �� �����ϴ�.";
		if(!ctype_alnum($id))
			return "ID�� ���Ĺ�� ���ڸ����� �̷������ �մϴ�.";
		if($pw==$id)
			return "ID�� ������ ��й�ȣ�� ����Ͻ� �� �����ϴ�.";
		if(quote($pw)==$sid)
			return "�й��� ������ ��й�ȣ�� ����Ͻ� �� �����ϴ�.";
		if(is_numeric($pw))
			return "���ڸ����� �̷���� �н������ ����Ͻ� �� �����ϴ�.";
		if(strlen($pw)<$minLen)
			return "�ּ� ".$minLen."�ڸ��� �Ѵ� �н����带 ����ϼž� �մϴ�.";
		if(counts($table, $clause)!=0)
			return "�̹� ���ǰ��ִ� ID�Դϴ�.";
		return null;
	}


	http_response_code(400);
	header("Content-type: application/json");
	$err = json_encode(Array("reason"=>"Exception/Error", "resultCode"=>-1));
	if(!isset($_POST["SID"])){
		echo $err;
		exit;
	}
	if(!isset($_POST["newID"])){
		echo $err;
		exit;
	}
	if(!isset($_POST["newPW"])){
		echo $err;
		exit;
	}
	$sid = $_POST["SID"];
	$id = $_POST["newID"];
	$email = $id."@hanyang.ac.kr";
	$newPW = $_POST["newPW"];
	$pw = pwd($newPW);

	$table = "User";
	//1. ��¥ ù �α������� DB��ȸ
	$clause = "WHERE SID=".quote($sid)." AND ID IS NULL";//�ش� �й��� ID�ʵ尡 null�̸� ù �α������� ����.
	//���� �˻��� ���ڵ尡 1�����(�������� ù �α����� ���) 
	if(counts($table, $clause)==1){
		//2. id, PW ����
		$reason = validation($id, $newPW);
		//���ο� id �� pw�� ��� valid��
		if($reason==null){
			//3. db update
			$set = Array("id"=>$id, "pw"=>$pw, "email"=>$email);
			$cnt = update($table, $set, $clause);
			//�������� update
			if($cnt==1){
				http_response_code(200);
				echo json_encode(Array("resultCode"=>1,"reason"=>null));
			}
			//3a. ���� update�� ������� ���ڵ� ������ 1���� �ƴ϶�� -1����(������)
			else{
				echo $err;
				exit;
			}
		}
		//invalid
		else{
			http_response_code(404);
			echo json_encode(Array("reason"=>$reason, "resultCode"=>0));
		}
	}
	//�˻��� ���ڵ尡 0�� Ȥ�� 2�� �̻��� ���(���������� ���)
	else{
		echo $err;
	}

?>