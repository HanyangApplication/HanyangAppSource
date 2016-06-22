<?php
	/* Author: 김진희
	 * 게시글 조회 수 증가를 위해서 사용함
	 * @Params
	 * postID
	 */
	
	function IncreaseNumberOfRead($postID){
	
		global $pdo, $POST_TABLE_NAME;
		
		//prepare statement build
		$prepare = "UPDATE $POST_TABLE_NAME SET numberOfRead = numberOfRead + 1 WHERE postID =".$postID.";";
		$stmt = rawQuery($prepare);
		return selectOne($POST_TABLE_NAME,"numberOfRead","where postID=".$postID);
	}
?>