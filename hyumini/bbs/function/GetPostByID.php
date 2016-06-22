<?php
// 저자: 김진희
include "bbs_db_settings.php";
function GetPostByID($id)
{
	global $POST_TABLE_NAME;
	$post_infomation_2d_array = selectAll($POST_TABLE_NAME, "*", "WHERE postID =".$id);
	return $post_infomation_2d_array[0];
}
?>