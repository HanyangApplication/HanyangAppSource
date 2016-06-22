<!--
저자

HTML 태그: 우승연

php 부분, HTML에서 버튼 누르면 다른 페이지로 넘어가는 부분
: 김진희

pageSwitch: 송형석


-->

<?php
include "bbs_db_settings.php";
session_start();
if(!isset($_SESSION["studentInfo"])) {
	echo "<meta http-equiv='refresh' content='0;url=../login/login.html'>";
	exit;
}


if ( isset($_GET['keyword']) && isset($_GET['option']) )
{
	$search_keyword = $_GET['keyword'];
	$search_option 	= $_GET['option'];
}

?>
<html>
	<head>
		<meta charset="utf-8"/>
		<link rel="stylesheet" type="text/css" href="style.css">
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<!-- jQuery library -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
		<!-- Latest compiled JavaScript -->
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<!-- CSS for page switch-->
		<link href="../PageSwitch/pageSwitch.css" type="text/css" rel="stylesheet">
	</head>
	<body>	
		<div id="topOption">
			<button class="btn btn-default" id="write" onclick="location='./contentWrite.php'">Write</button>
			<form action="./contentList.php" method="get">
			<div id="searchSetting" class="form-group">
				<select name ="option" class="form-control">
					<option value="title">Title</option>
					<option value="author">Author</option>
					<option value="all">All</option>
				</select>
			</div>
			<div>
				<input type="text" id="searchKeyword" placeholder="Search..." name ="keyword"></input>
				<input class="btn btn-default" type="submit" id="search" value = "Go"></input>
			</div>
			</form>	
		</div>
		<br/>
		<div class ="line">
		<!--
			<pre>제목					작성자 조회수</pre>
		-->	
			<pre class = "number_of_reads">조회수</pre>
			<pre class = "writer">작성자</pre>
			<pre class = "title">제목</pre>
			
			
			<?php
				// 맨 아래에 기술함
				ShowAllList();
			?>
		</div>
		<div class="pageSwitch">
<<<<<<< HEAD
          <div ><a  href="http://selab.hanyang.ac.kr/hyumini/main/main.html">Home</a></div>
          <div><a href="../bus/shuttle.html">Shuttle</a></div>
          <div><a href="../WeeklyMenu/weeklymenu.php">Meal</a></div>
          <div><a class="active" href="../bbs/contentList.php">BBS</a></div>
     	</div>
=======
		    <div ><a  href="./">ID card</a></div>
		    <div><a href="../lecture">Schedule</a></div>
		    <div><a href="../bus/shuttle.html">Shuttle</a></div>
		    <div><a href="../WeeklyMenu/index.php">Meal</a></div>
		    <div><a class="active" href="../bbs/">BBS</a></div>
		</div>
>>>>>>> 2873a68b686eb6814f890248c428eb3ba3bb38c1
	</body>
</html>


<?php
function ShowAllList()
{
	global $POST_TABLE_NAME;

	$search_condition = get_search_condition();
	
	$array_2d = selectAll($POST_TABLE_NAME, "*", $search_condition);
	if ( isset($array_2d) )
	foreach ( $array_2d as $array )
	{
		ShowOneList($array);		
	}
}


function ShowOneList($array)
{
	$id = $array['postID'];

	echo "</pre><pre class = \"number_of_reads\">";
	echo $array['numberOfRead'];
	echo "</pre>";

	echo "</pre><pre class = \"writer\">";
	echo $array['writer'];
	echo "</pre>";
	
	echo "<pre class = \"title\">";
	echo "<a href='./contentPage.php?id=$id'>";
	echo $array['title'];
	echo "</a>";
}


function get_search_condition()
{
	$string ="";
	global $search_option, $search_keyword;
	
	if ( isset($search_option) )
	switch ( $search_option ) {
	case "title":
		$string .= "WHERE title LIKE '%".$search_keyword."%'";
		break;
	case "author":
		$string .= "WHERE writer LIKE '%".$search_keyword."%'";
		break;
	case "all":
		$string .= "WHERE title LIKE '%".$search_keyword."%' 
					OR	  writer LIKE '%".$search_keyword."%'";
		break;		
	}
	$string .= " ORDER BY postID DESC";
	
	return $string;
}



?>