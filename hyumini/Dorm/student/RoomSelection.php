<?php
	require_once 'Mysqli.php';

	$response = [
	'status'=>"500",
	'message'=>'mission failed.'
];

	$id =$_POST['i'];
	$name = $_POST['n'];
	$building = $_POST['b'];
	$room =$_POST['r'];
	$roomType =$_POST['rt'];


	$sql = "select `status` from `students` where `id`=$id";
	$result = mysqli->query($sql);

	$flag = $result['0'];

	echo $flag;
	if ($flag == 1) {
		# code...
		$sql = "update `students` set `a_building`=$building, 'a_room'=$room, `roomtype`=$roomType where `id`=$id";
		mysqli->query($sql);

		mysqli->close();

	}
?>