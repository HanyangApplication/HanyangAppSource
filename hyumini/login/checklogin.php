<?php
	require("../db.php");
	/*
	 * Author: ������
	 *
	 * @Description
	 * �α��� ��, login.html���� ajax request�� �� �ڵ�� ������ 
	 * �α����� �����ߴ���, �����ߴ���, ù �α�������, ����������, �л����� ���� 
	 * Authentication ������ ���ڵ带 �����մϴ�.
	 * 
	 * @Returns
	 * json ���ڿ��� �Ѱ��ݴϴ�.
	 * records: ��ȸ�� ���ڵ� �����Դϴ�.
	 * returnCode: ���� �ڵ�� ������ �����ϴ�.
	 * Error:			-1
	 * Fail:			 0
	 * Success:			 1
	 * First Login:		 2
	 * Admin:			 3
	 * Admin & First:	 4
	 *
	 */
	$err = json_encode(Array("returnCode"=>-1));
	if(!isset($_POST["id"])){
		echo $err;
		exit;
	}
	if(!isset($_POST["pw"])){
		echo $err;
		exit;
	}
	$id = quote($_POST["id"]);
	$pw = quote(pwd($_POST["pw"]));

	$table = "User";
	$clause = "WHERE (ID=".$id." OR studentID=".$id.") AND password = ".$pwd;
	$cnt = counts($table, $clause);

	$returnCode = -1;
	//�Էµ� ID/PW�� ��Ī�Ǵ� ���ڵ尡 ����
	if($cnt==0){
		$clause = "WHERE ID=NULL AND studentID=".$id." AND password=".quote($_POST["pw"]);//pwd�Լ��� ���� ����.
		//������ �� �߿����� First Login�� ���.
		if(counts($table, $clause)==1){
			$column = "access";
			$access = selectOne($table, $column, $clause);
			//�ٵ� ���� �������� ��� - access�� 1
			if($access==1){
				$returnCode = 4;	
			}
			//�����ڴ� �ƴϰ� �Ϲ� �л��� ���
			else{
				$returnCode = 2;
			}	
		}
		//First Login�� �ƴѰ��
		else{
			$returnCode = 0;
		}
	}
	//�Էµ� ID/PW�� ��Ī�Ǵ� ���ڵ尡 '�� �ϳ�' �����ϴ� ���.
	else if($cnt==1){
		$column = "access";
		$access = selectOne($table, $column, $clause);
		//�α����Ѱ� Admin�� ���
		if($access==1){
			$returnCode = 3;
		}
		//�α����Ѱ� �Ϲ� �л��� ���
		else{
			$returnCode = 1;
		}
	}
	//��Ī�Ǵ� ���ڵ尡 �ΰ� �̻� ���� => ���������� ����
	else{
		echo $err;
		exit;
	}

	//���� �α��ο� �����߰ų� Ȥ�� ù �α����� ��� ���ڵ� ��ȸ�� �ʿ� ����.
	if($returnCode%2==0){
		echo json_encode(Array("returnCode"=>$returnCode));
	}
	//�׳� ���������� ������ ��쿡�� ���ڵ嵵 ��ȸ�ؼ� ������ �Ѱ���.
	else{
		//ID�� password�� �Ѱ��� �ʿ� ����.
		//������ access�� returnCode�� ���������� �ƴ��� �� �� ����.
		//���� �й�, �̸�, �̸��ϸ� ��ȸ�ؼ� �Ѱ��ش�.
		$columns = Array("studentID", "name", "email");
		$records = selectAll($table, $columns, $clause);
		
		$arr = Array("records"=>$records, "returnCode"=>$returnCode);
		$json = json_encode($arr);
		echo $json;

	}
	//Unreachable Code
	echo $err;

?>