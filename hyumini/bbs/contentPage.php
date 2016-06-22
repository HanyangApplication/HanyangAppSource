<!--
저자

HTML 태그: 우승연

php 부분, HTML에서 버튼 누르면 다른 페이지로 넘어가는 부분
: 김진희

pageSwitch: 송형석


-->


<?php
include "function/GetPostByID.php";
include "function/IncreaseNumberOfRead.php";
include "reply_function/show_all_replies_in_post.php";

session_start();
if(!isset($_SESSION["studentInfo"])) {
	echo "<meta http-equiv='refresh' content='0;url=../login/login.html'>";
	exit;
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
		<?php
			$id = $_GET['id'];
			$array = GetPostByID($id);
			IncreaseNumberOfRead($id);
			
			$title = $array['title'];
			$numberOfRead = $array['numberOfRead'];
			$writer = $array['writer'];
		?>
		<div id="contentWrap">
			<div id="onlyContent">
				<div>
				
				<pre class = "number_of_reads_in_content" 
					id="author"><?="조회수: ".$numberOfRead."\n\n"?></pre>
				<pre class = "title" id="title"><?="제목: ".$title
												."\n글쓴이: ".$writer?></pre>			
				<br/>
			</div>		
			<div>
				<pre id="content"><?=$array['content']?></pre>
				<br/>
			</div>
			</div>
			
			
		
		
		<div>			
			<!-- <?
			echo "<p></p>";
			?> -->
			<div>
			<!-- 아래와 같은 내용을 php로 생성한다. -->
			<!--
				<p id="replyAuthor">아엠어오써 </p>
			-->	
			<!--
				<button id="replyEdit">Edit</button>
				<button id="replyDelete">Delete</button>
				<p id="replyContent">replycontent~~~</p>
			-->
			<?php
				if ( isset($_GET['replyID']) )
				{
					$reply_id_to_edit = $_GET['replyID'];
					show_all_replies_in_post($id, $reply_id_to_edit);
				}
				else
				{
					show_all_replies_in_post($id);
				}
			?>			
			</div>
			
		</div>
		</div>
		<div>
				<button class="btn btn-default cpbtn" id="prev" onclick="location.href='./contentList.php'";>prev</button>
				<button class="btn btn-success cpbtn" id="edit" onclick="location.href='./contentEdit.php?id=<?=$id?>&writer=<?=$writer?>'";>Edit</button>
				<button class="btn btn-danger cpbtn" id="delete" onclick="location.href='./function/delete.php?id=<?=$id?>&writer=<?=$writer?>'";>Delete</button>
				<br/><br/><br/>
		</div>
		<div class="pageSwitch">
	      <div ><a  href="http://selab.hanyang.ac.kr/hyumini/main/main.html">Home</a></div>
	      <div><a href="../bus/shuttle.html">Shuttle</a></div>
	      <div><a href="../WeeklyMenu/weeklymenu.php">Meal</a></div>
	      <div><a class="active" href="../bbs/contentList.php">BBS</a></div>
	 	</div>
	</body>
</html>