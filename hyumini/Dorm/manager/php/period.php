<?php

require_once 'Mysqli.php';

$response = [
	'status'=>"500",
	'message'=>'mission failed.'
];

if (isset($_GET['peioid']) && $_GET['peioid'] == '1') {
	//获取最后一条数据
	$sql = 'SELECT periodtime.year AS `year`, periodtime.period AS `period`, periodtime.begin AS `begin`, periodtime.due AS `due`
FROM `periodtime` WHERE 1 ORDER BY `id` DESC LIMIT 1;';

	$result = $mysqli->query($sql);

	$response['status'] = '200';
	$response['message'] = 'success';
	$response['data'] = $result->fetch_all(MYSQLI_ASSOC)[0];
}else if(isset($_POST['year'])) {
	$year = $_POST['year'];
	$period = $_POST['period'];
	$begin = $_POST['begin'];
	$due = $_POST['due'];

	//预处理，防注入
	$sql = "INSERT INTO `periodtime`(`year`, `period`, `begin`, `due`)
			VALUES (?, ?, ?, ?);";
	$stmt = $mysqli->prepare($sql) or die($mysqli->error);	
	
	$stmt->bind_param("isss", $year, $period, $begin, $due);
	
	$flag = $stmt->execute();

	$response['status'] = '200';
	if($flag) {
		$response['message'] = 'Data update successed.';
	}else {
		$response['message'] = 'Database error';
	}
}

$mysqli->close();

echo json_encode($response);
