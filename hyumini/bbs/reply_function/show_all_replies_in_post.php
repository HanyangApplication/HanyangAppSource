<?php
/* Author: 김진희  */
function show_all_replies_in_post($postID, $reply_id_to_edit = 0)
{
	global $REPLY_TABLE_NAME;

	$search_condition = "where postID=".$postID." ORDER BY replyID ASC";
	
	$array_2d = selectAll($REPLY_TABLE_NAME, "*", $search_condition);
	if ( isset($array_2d) )
	foreach ( $array_2d as $array )
	{
		ShowOneList($array, $reply_id_to_edit);		
	}
	if ($reply_id_to_edit == 0 )
	{
		show_empty_textarea_to_write($postID);
	}
}

// <pre> 태그는 후에 지워야 할 듯
function ShowOneList($array, $reply_id_to_edit)
{
	$replyID = $array['replyID'];	
	if ( $replyID == $reply_id_to_edit )
	{
		ShowOneEdit($array);
	}
	else
	{
		ShowOneReply($array);
	}
}


function ShowOneEdit($array)
{
	$postID = $array['postID'];
	$replyID = $array['replyID'];
	$writer  = $array['writer'];
	
	
	echo '<br/>';
	echo "<form action=\"reply_function/editSave.php?postID=$postID&replyID=$replyID&writer=$writer\" method=\"post\">";		
	echo '<input type="text" value="'.$array['content'].'" name = "content"></input>';
	echo '<input type="submit" id="save" value = "save"></input>';
	echo '</form>';
	echo '<br/>';
}


function ShowOneReply($array)
{
	$postID = $array['postID'];
	$replyID = $array['replyID'];
	$writer = $array['writer'];
	
	echo "<pre>";
	echo '<p id="replyAuthor">'.$writer.'</p>';
	echo '<pre id="replyContent">'.$array['content'].'</pre>';
	echo "<button class=\"btn btn-success cpbtn\" id=\"replyEdit\"
			onclick=\"location='./contentPage.php?id=$postID&replyID=$replyID&writer=$writer'\"
			>Edit</button>";
	
	echo "<button class=\"btn btn-danger cpbtn\" id=\"replyDelete\" 
			onclick=\"location='./reply_function/delete.php?postID=$postID&replyID=$replyID&writer=$writer'\">
			Delete</button>";
	echo "</pre>";
	
	
	
}


function show_empty_textarea_to_write($postID)
{
	echo 
	'
	<br/>
	<form action="reply_function/writeSave.php?postID='.$postID.'" method="post">
	
	<input type="text" placeholder="reply" name = "content"></input>
	<button class="btn btn-primary cpbtn" type="submit" id="save" >save</button>
	
	</form>
	';
}
?>