<?php
/* Author: 김진희 */
include "reply_db_settings.php";

session_start();

$postID = $_GET['postID'];


$writer = $_GET['writer'];
if ( $writer == $_SESSION["studentInfo"]['name'] )
{
	
	$replyID = $_GET['replyID'];
	update($REPLY_TABLE_NAME,
		Array("content"=>$_POST['content']),
		Array
		("where"=>
		"postID=".$postID." AND replyID=".$replyID
		
			));
}		
?>

<html>
	<meta http-equiv="refresh" content="0; url=../contentPage.php?id=<?=$postID?>"/>
</html>

