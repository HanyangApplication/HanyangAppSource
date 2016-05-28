<?php
	require("../db.php");
	/*
	 *	Author: ������
	 *
	 *	@Description
	 *	�α��� ��, login.html���� ajax request�� �� �ڵ�� ������ 
	 *	�α����� �����ߴ���, �����ߴ���, ù �α�������, ����������, �л����� ���� 
	 *	���¿� ��� ���ڵ带 �����մϴ�.
	 * 
	 *	@Param(GET)
	 *	id: �Է¹��� id(Ȥ�� �й�)
	 *	pw: �Է¹��� �н�����
	 *
	 *	@Return(JSON)
	 *	records: ��ȸ�� ���ڵ� �����Դϴ�.
	 *	resultCode: ���� �ڵ�� ������ �����ϴ�.
	 *
	 *								HTTP Response Code
	 *	Error			:	-1		400/500
	 *	Fail			:	 0		404
	 *	Success			:	 1		200
	 *	First Login		:	 2		200
	 *	Admin			:	 3		200
	 *	Admin & First	:	 4		200
	 *
	 */
	http_response_code(400);
	header("Content-type: application/json");
	$err = json_encode(Array("resultCode"=>-1,"records"=>null));
	if(!isset($_GET["id"])){
		echo $err;
		exit;
	}
	if(!isset($_GET["pw"])){
		echo $err;
		exit;
	}
	$id = quote($_GET["id"]);
	$pw = quote(pwd($_GET["pw"]));

	$table = "User";
	$clause = "WHERE (ID=".$id." OR SID=".$id.") AND PW = ".$pw;
	$cnt = counts($table, $clause);

	$resultCode = -1;
	//�Էµ� ID/PW�� ��Ī�Ǵ� ���ڵ尡 ����
	if($cnt==0){
		$clause = "WHERE ID IS NULL AND SID=".$id." AND PW=".quote($_GET["pw"]);//pwd�Լ��� ���� ����.
		//������ �� �߿����� First Login�� ���.
		if(counts($table, $clause)==1){
			$column = "master";
			$master = selectOne($table, $column, $clause);
			//�ٵ� ���� �������� ��� - master�� 1
			if($master==1){
				$resultCode = 4;	
			}
			//�����ڴ� �ƴϰ� �Ϲ� �л��� ���
			else{
				$resultCode = 2;
			}	
		}
		//First Login�� �ƴѰ��
		else{
			$resultCode = 0;
		}
	}
	//�Էµ� ID/PW�� ��Ī�Ǵ� ���ڵ尡 '�� �ϳ�' �����ϴ� ���.
	else if($cnt==1){
		$column = "master";
		$master = selectOne($table, $column, $clause);
		//�α����Ѱ� Admin�� ���
		if($master==1){
			$resultCode = 3;
		}
		//�α����Ѱ� �Ϲ� �л��� ���
		else{
			$resultCode = 1;
		}
	}
	//��Ī�Ǵ� ���ڵ尡 �ΰ� �̻� ���� => ���������� ����
	else{
		echo $err;
		exit;
	}

	//�α��ο� ������ ���
	if($resultCode==0){
		http_response_code(404);
		echo json_encode(Array("resultCode"=>0,"records"=>null));
	}
	//ù �α����� ��� ���ڵ� ��ȸ�� �ʿ� ����.
	else if($resultCode%2==0){
		http_response_code(200);
		echo json_encode(Array("resultCode"=>$resultCode,"records"=>null));
	}
	//�׳� ���������� ������ ��쿡�� ���ڵ嵵 ��ȸ�ؼ� ������ �Ѱ���.
	else{
		//ID�� PW�� �Ѱ��� �ʿ� ����.
		//������ master�� resultCode�� ���������� �ƴ��� �� �� ����.
		//���� �й�, �̸�, �̸��ϸ� ��ȸ�ؼ� �Ѱ��ش�.
		$columns = Array("SID", "name", "email");
		$records = selectAll($table, $columns, $clause);
		
		$arr = Array("records"=>$records, "resultCode"=>$resultCode);
		$json = json_encode($arr);
		http_response_code(200);
		echo $json;
	}

?>