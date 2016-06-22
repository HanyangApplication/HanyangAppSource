<?php

require_once 'Mysqli.php';
	


	$name=$_POST['n'];
	$id=$_POST['i'];
	$building=$_POST['b'];
	$roomType=$_POST['r'];
	$disability=$_POST['d'];
	$address=$_POST['a'];
	$remark=$_POST['re'];

	echo "successful!";

	$sql = "insert into `students` (`name`,`id`,`a_building`,`roomtype`,`disability`,`address`,`remark`) 
			values($name,$id,$building,$roomType,$disability,$address,$remark)"
	/*if($mysqli->query($sql)){

		echo '데이터를 삽입함';
	}
	else
	{
		echo '실패';

	}*/
	mysqli->query($sql);
	
	$mysqli->close();
?>