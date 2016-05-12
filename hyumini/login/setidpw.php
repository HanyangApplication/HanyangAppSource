<?php
	require("../db.php");
	/*
	 *	Author: ������
	 *	@Description
	 *	ù �α��� ��, firstlogin.html���� ajax request�� �� �ڵ�� ������ 
	 *	���ο� id�� password�� �����մϴ�.
	 * 
	 *	@Param(POST)
	 *	studentID: login.html���� �Է¹��� �й�
	 *	newID: ���� ������ id
	 *	newPW: ���� ������ pw
	 *
	 *	@Return(JSON)
	 *	reason: ���� ���н��� �����Դϴ�.
	 *	resultCode: ���� �ڵ�� ������ �����ϴ�.
	 * 
	 *	Setting Success	  :  1
	 *	Setting Failed	  :  0
	 *	Exception/Error	  : -1
	 */
	$err = json_encode(Array("reason"=>"Exception/Error", "resultCode"=>-1));
	if(!isset($_POST["studentID"])){
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
	$sid = quote($_POST["studentID"]);
	$email = quote($_POST["newID"]."@hanyang.ac.kr");
	$id = quote($_POST["newID"]);
	$pw = quote(pwd($_POST["newPW"]));

	$table = "User";
	//1. ��¥ ù �α������� DB��ȸ
	$clause = "WHERE studentID=".$sid." AND ID=NULL";//�ش� �й��� ID�ʵ尡 null�̸� ù �α������� ����.
	//���� �˻��� ���ڵ尡 1�����(�������� ù �α����� ���) 
	if(counts($table, $clause)==1){
		//2. id, password ����
		$reason = validation($_POST["newID"], $_POST["newPW"]);
		//���ο� id �� pw�� ��� valid��
		if($reason==null){
			//3. db update
			$set = Array("id"=>$id, "password"=>$pw, "email"=>$email);
			$cnt = update($table, $set, $clause);
			//�������� update
			if($cnt==1){
				echo json_encode(Array("resultCode"=>1));
			}
			//3a. ���� update�� ������� ���ڵ� ������ 1���� �ƴ϶�� -1����(������)
			else{
				echo $err;
				exit;
			}
		}
		//invalid
		else{
			echo json_encode(Array("reason"=>$reason, "resultCode"=>0));
		}
	}
	//�˻��� ���ڵ尡 0�� Ȥ�� 2�� �̻��� ���(���������� ���)
	else{
		echo $err;
		exit;
	}
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
		global $sid;
		$maxLen = 24;
		$clause = "WHERE id=".quote($id);
		if(strlen($id)>$maxLen){
			return $maxLen."�ڸ��� �Ѵ� ID�� ����Ͻ� �� �����ϴ�.";
		}else if(is_numeric($id)){
			return "���ڸ����� �̷���� ID�� ����Ͻ� �� �����ϴ�.";
		}else if(!ctype_alnum($id)){
			return "ID�� ���Ĺ�� ���ڸ����� �̷������ �մϴ�.";
		}else if($pw==$id){
			return "ID�� ������ ��й�ȣ�� ����Ͻ� �� �����ϴ�.";
		}else if(quote($pw)==$sid){
			return "�й��� ������ ��й�ȣ�� ����Ͻ� �� �����ϴ�.";
		}else if(counts($table, $clause)!=0){
			return "�̹� ���ǰ��ִ� ID�Դϴ�."
		}
		return null;
	}
?>