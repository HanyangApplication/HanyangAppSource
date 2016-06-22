<!DOCTYPE html>


<!--
	 Author: 성다혜
	 @Description
	 식단 데이터를 가져오기 전부터 있을 내용을 정의합니다.
-->

<html>
<head>
  <title></title>
  <meta charset="utf-8">
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

  <link rel="stylesheet" type="text/css" href="weeklyCSS.css">

  <!-- Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>

  <!-- Latest compiled and minified JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

  <script type="text/javascript" src="weeklymenuJS.js"></script>

  <!-- CSS for page switch-->
  <link href="../PageSwitch/pageSwitch.css" type="text/css" rel="stylesheet">

</head>
<body class="panel panel-default">
<!-- <div class="panel panel-default"> -->
  <div class="panel-heading">
    <h3 class="panel-title">HYU(e)mini</h3>
  </div>
  <div class="panel-body">
      <span class="label label-primary col-xs-12 nameLabel">이번주 식단</span>
    <div class="btnGroup">
      <div class="btn-group" role="group" aria-label="">
        <button type="button" class="btn btn-default btn_day_0">월</button>
        <button type="button" class="btn btn-default btn_day_1">화</button>
        <button type="button" class="btn btn-default btn_day_2">수</button>
        <button type="button" class="btn btn-default btn_day_3">목</button>
        <button type="button" class="btn btn-default btn_day_4">금</button>
        <button type="button" class="btn btn-default btn_day_5">토</button>
        <button type="button" class="btn btn-default btn_day_6">일</button>
      </div>
    </div>
    <nav>
      <ul class="pager">
		<!--<?= $breakfast ?>-->
		<li><a class = "btn_time_0">조식 ></a></li>
        <li><a class = "btn_time_1">중식 ></a></li>
        <li><a class = "btn_time_2">석식 ></a></li>
		<!--
        <li><a href="#">Breakfast ></a></li>
        <li><a href="#">Lunch ></a></li>
        <li><a href="#">Dinner ></a></li>
		-->
      </ul>
    </nav>

	<?php
	include "./MenuMaker.php";
	?>

  <div class="pageSwitch">
      <div ><a  href="http://selab.hanyang.ac.kr/hyumini/main/main.html">Home</a></div>
      <div><a href="../bus/shuttle.html">Shuttle</a></div>
      <div><a class="active" href="../WeeklyMenu/weeklymenu.php">Meal</a></div>
      <div><a href="../bbs/contentList.php">BBS</a></div>
  </div>
<!-- </div> -->
</body>
</html>
