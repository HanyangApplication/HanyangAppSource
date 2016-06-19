<!--
저자

HTML 태그: 우승연

php 부분, HTML에서 버튼 누르면 다른 페이지로 넘어가는 부분
: 김진희

pageSwitch: 송형석


-->

<?php
include "function/GetPostByID.php";
session_start();
if(!isset($_SESSION["studentInfo"])) {
	echo "<meta http-equiv='refresh' content='0;url=../login/login.html'>";
	exit;
}

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<!-- CSS for page switch-->
		<link href="../PageSwitch/pageSwitch.css" type="text/css" rel="stylesheet">
	</head>

	<body>
	<?php
			$id = $_GET['id'];
			$writer = $_GET['writer'];
			$array = GetPostByID($id);
	?>	
	<form action="function/editSave.php?id=<?=$id?>&writer=<?=$writer?>" method="post">
		<p>Title</p>
		<textarea id="title" name = "title"><?=$array['title']?></textarea>
		<p>Content</p>
		<textarea id="content" name = "content"><?=$array['content']?></textarea>
		<input type="submit" id="save" value = "Save"></input>	
		<!--<button id="calcel">Cancel</button>-->
		<input type="button" id="calcel" value = "Cancel" 
			onclick="location='./contentPage.php?id=<?=$id?>'">
			</input>
	</form>
	<div class="pageSwitch">
	    <div ><a  href="./">ID card</a></div>
	    <div><a href="../lecture">Schedule</a></div>
	    <div><a href="../bus/shuttle.html">Shuttle</a></div>
	    <div><a href="../WeeklyMenu/index.php">Meal</a></div>
	    <div><a class="active" href="../bbs/">BBS</a></div>
	</div>
	</body>
</html>