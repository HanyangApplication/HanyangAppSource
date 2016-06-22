<?php
	$user = 'hyumini';
	$pw = 'hyu(e)mini';
	$db = 'hyumini';
	$host = '127.0.0.1';
	$port = 3306;
	
	$mysqli = new mysqli($host,$user,$pw,$db,$port);

	if ( !$mysqli ) {
		die("Connect Database failed: " . mysqli_connect_errno());
	};

	mysqli_query($mysqli,"set names utf8");