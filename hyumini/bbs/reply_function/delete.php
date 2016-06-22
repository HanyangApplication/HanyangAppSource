<?php
/* Author: 김진희 */
include "reply_db_settings.php";
session_start();


$postID = $_GET['postID'];

$writer = $_GET['writer'];
if ( $writer == $_SESSION["studentInfo"]['name'] )
{	
	$replyID = $_GET['replyID'];
	deletes($REPLY_TABLE_NAME,"where replyID=".$replyID." AND postID =".$postID);;
}
?>

<html>
	<meta http-equiv="refresh" content="0; url=../contentPage.php?id=<?=$postID?>"/>
</html>
