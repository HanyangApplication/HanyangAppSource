<?php
	/*
	 *	Author: 성다혜, 김진희
	 *	@Description
	 *	WeeklyMenuGetter.php 를 불러와서,
	 *	식단 데이터를 변수와 배열에 모두 저장하고,
	 *	
	 *	저장한 데이터를 적당한 HTML 태그와 같이 출력합니다.
	 *	HTML 태그: 성다혜
	 *	나머지 코드: 김진희
	 */


	include "./WeeklyMenuGetter.php";



	$format_index_string ='<P>%d, %d</P>';


	for ($time_index=0; $time_index<3; $time_index++)
	{
		$time = get_time_by_i($time_index);
		for ($day_index = 0; $day_index < 7; $day_index++)
		{
			$day_of_week = get_day_of_week_by_j($day_index);
			//$string = sprintf($format_index_string, $time_index, $day_index);
			//echo $string;


			//echo "<div class = \"menu $time $day_of_week\">";
			echo "<div class = \"menu menu$time_index$day_index \">";
			//echo "<p> menu$time_index$day_index </p>";

			// ±³A÷¿ø½A´c, CÐ≫y½A´c, ±a¼÷≫c½A´c, CªμaAUÆ®, A￠¾÷º¸A°¼¾AI ¼ø¼­·I
			// 0,1,2,3,4

			if ( isset($menu[1]) && array_key_exists($time_index, $menu[1] ) )
			show_menu_in_time("학생 식당", "studentRes", "studentResInfo", $menu[1][$time_index], $price[1][$time_index], $day_index);
			if ( isset($menu[0]) && array_key_exists($time_index, $menu[0] ) )
			show_menu_in_time("교직원 식당", "staffRes", "staffResInfo", $menu[0][$time_index], $price[0][$time_index], $day_index);
			// 푸드코트
			if (isset($menu[3]) && $time_index != 0)
			{
				show_foodcourt_menu($menu[3], $price[3], $day_index);
			}
			if ( isset($menu[2]) && array_key_exists($time_index, $menu[2] ) )
			show_menu_in_time("기숙사 식당", "DormRes", "DormResInfo", $menu[2][$time_index], $price[2][$time_index], $day_index);
			
			if ( isset($menu[4]) && array_key_exists($time_index, $menu[4] ) )
			show_menu_in_time("창업 보육 센터", "StartupRes", "StartupResInfo", $menu[4][$time_index], $price[4][$time_index], $day_index);

			echo "</div>";
		}
	}


	function show_foodcourt_menu($menu, $price, $day_index)
	{
		//, $menu[3][$time_index], $price[3][0], $day_index
		$size = count($menu[0]);
		//echo "size °ª: $size </BR>\n";
		if ($size <= 1 || !isset($menu[0][0][$day_index]) )
		{
			return;
		}

		$string = "
			<div>
				<button type=\"button\" class=\"btn btn-info restaurant FC\">푸드 코트</button>
				<div class=\"alert alert-info FCInfo\" role=\"alert\">
					<nav>
					  <ul class=\"pager\">
					    <li class = \"btn_foodcourt_0\"><a>한식 ></a></li>
						<li class = \"btn_foodcourt_1\"><a>양식 ></a></li>
						<li class = \"btn_foodcourt_2\"><a>분식 ></a></li>
					  <!--
						<li class = \"btn_korean\"><a>한식 ></a></li>
						<li class = \"btn_western\"><a>양식 ></a></li>
						<li class = \"btn_snack\"><a>분식 ></a></li>
					  -->
					  </ul>
					</nav>
					<div class=\"alert alert-danger menuList\" role=\"alert\">	";
		echo $string;



		//$kind = array("korean", "western", "snack");
		$kind = array("foodcourt0", "foodcourt1", "foodcourt2");
		for ($kind_index = 0; $kind_index < count($kind); $kind_index++)
		{
			echo 		"<div class=\"{$kind[$kind_index]}\" role=\"alert\">";
			$size = count($menu[$kind_index]);
			for ($item_index = 0; $item_index < $size; $item_index++)
			{
				$string = $menu[$kind_index][$item_index][$day_index];
				if ($string !="")
				{
					echo 	"<p>{$string}</p>";
				}
			}
			echo 		"</div>";
		}



		$string = '
					</div>
					<div class="alert alert-danger menuCost" role="alert">
				';
		echo $string;



		for ($kind_index = 0; $kind_index < count($kind); $kind_index++)
		{
			echo 		"<div class=\"{$kind[$kind_index]}\" role=\"alert\">";
			$size = count($price[$kind_index]);
			for ($item_index = 0; $item_index < $size; $item_index++)
			{
				$string = $price[$kind_index][$item_index][$day_index];
				if ($string !="")
				{
					echo 	"<p>{$string}</p>";
				}
			}
			echo 		"</div>";
		}

		$string = '
					</div>
				</div>
			</div>
			';
		echo $string;
	}




	function show_menu_in_time($restraunt_title, $button_class, $menu_class, $menu_in_time, $price_in_time, $day_index)
	{
		$size = count($menu_in_time);
		//echo "size °ª: $size </BR>\n";
		if ($size <= 1 || !isset($menu_in_time[0][$day_index]) )
		{
			return;
		}

		$string = "
			<div>
				<button type=\"button\" class=\"btn btn-info restaurant $button_class\">$restraunt_title</button>
			  <div class=\"alert alert-info $menu_class\" role=\"alert\">
				<div class=\"alert alert-danger menuList\" role=\"alert\">
				";
		echo $string;

		for ($k = 0; $k < $size; $k++)
		{	
			//echo "<p>k값: $k</p>";
			//if ($string !="")
			if ( array_key_exists($day_index, $menu_in_time[$k]) )
			{
				$string = $menu_in_time[$k][$day_index];
				echo "<p>{$string}</p>";
			}
		}

		$string = '
				</div>
				<div class="alert alert-danger menuCost" role="alert">
				';
		echo $string;

		
		$size = count($price_in_time);
		//echo "<p>$size</p>";
		for ($k = 0; $k < count($price_in_time); $k++)
		{
			if ( isset ( $price_in_time[$k][$day_index] ) )
			{
				$string = $price_in_time[$k][$day_index];
				echo "<p>{$string}</p>";
			}
		}
	

		$string = '
				</div>
			  </div>
			</div>
			';
		echo $string;
	}


	// ¾Æ·¡ μI function Aº html¿¡¼­ class ¸| A¤ACCI±a A§CØ¼­ ¾¸
	// class ¸| A¤ACCI´A AIA?: AU¹U ½ºAⓒ¸³Æ®¿¡¼­ hide ¸| ¾²±a A§CØ
	function get_time_by_i($i)
	{
		switch($i)
		{
		case 0:
			return "breakfast";
		case 1:
			return "lunch";
		case 2:
			return "diner";
		default:
			return "";
		}
	}


	function get_day_of_week_by_j($j)
	{
		switch($j)
		{
		case 0:
			return "mon";
		case 1:
			return "tue";
		case 2:
			return "wed";
		case 3:
			return "thur";
		case 4:
			return "fri";
		case 5:
			return "sat";
		case 6:
			return "sun";
		}
	}

?>
