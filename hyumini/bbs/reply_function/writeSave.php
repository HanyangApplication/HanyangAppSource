<?php
/* Author: 김진희 */
include "reply_db_settings.php";
session_start();
if(!isset($_SESSION["studentInfo"])) {
	echo "<meta http-equiv='refresh' content='0;url=../../login/login.html'>";
	exit;
}


$postID = $_GET['postID'];
insert($REPLY_TABLE_NAME,Array("content", "writer", "postID"),
				Array($_POST['content'], $_SESSION["studentInfo"]['name'], $postID));
				//Array($_POST['content'], $_POST['writer'], $postID));

?>

<html>
	<meta http-equiv="refresh" content="0; url=../contentPage.php?id=<?=$postID?>"/>
</html>
