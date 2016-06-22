<?php
// 저자: 김진희
include "bbs_db_settings.php";
session_start();

$id = $_GET['id'];

$writer = $_GET['writer'];
if ( $writer == $_SESSION["studentInfo"]['name'] )
{	
	update($POST_TABLE_NAME,
		Array("title"=>$_POST['title'],
			  "content"=>$_POST['content']),
		Array("where"=>"postID=".$id));			
}		
?>
<html>
	<meta http-equiv="refresh" content="0; url=../contentPage.php?id=<?=$id?>"/>
</html>