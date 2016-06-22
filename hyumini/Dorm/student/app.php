<?php
	$user = 'hyumini';
	$pw = 'hyu(e)mini';
	$db = 'hyumini';
	$host = '127.0.0.1';
	$port = 3306;
	$table = 'students';
	
	$my_db = new mysqli($host,$user,$pw,$db,$port);
	mysqli_query($my_db,"set names utf8");
	if ( mysqli_connect_errno() ) {
			echo mysqli_connect_errno();
			exit;
	}
	//echo $my_db;
	$id=$_POST['i'];
	$name=$_POST['n'];
	$building=$_POST['b'];
	//$due=$_POST['d'];
	echo "successful!";
	//$my_db->query("select * from $table");
	mysqli_query($my_db,"insert into $table (`name`,`id`,`building`) values($name,$id,$building)"); // 	echo "successful11!";
	
	
	
	//mysqli_query($my_db,"insert into $table(year,period,begin,due) values($year,$period,$begin,$due)");
	mysqli_close($my_db);
?>