<?php
// 저자: 김진희
include "bbs_db_settings.php";
session_start();
$writer = $_GET['writer'];
if ( $writer == $_SESSION["studentInfo"]['name'] )
{
	$id = $_GET['id'];
	deletes($POST_TABLE_NAME,"where postID=".$id);
	deletes($REPLY_TABLE_NAME,"where postID=".$id);
}
?>
<html>
	<meta http-equiv="refresh" content="0; url=../contentList.php"/>
</html>