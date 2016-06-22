<?php
	/* Author: 김진희 */
include "bbs_db_settings.php";
session_start();
if(!isset($_SESSION["studentInfo"])) {
	echo "<meta http-equiv='refresh' content='0;url=../../login/login.html'>";
	exit;
}

insert($POST_TABLE_NAME,Array("title", "content", "writer", "numberOfRead"),
				Array($_POST['title'], $_POST['content'], $_SESSION["studentInfo"]['name'], "0"));
			
$id = $pdo->lastInsertId();

?>

<html>
	<meta http-equiv="refresh" content="0; url=../contentPage.php?id=<?=$id?>"/>
</html>
