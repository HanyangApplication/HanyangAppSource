<?php
	
	/*
	 *	Author: 김진희
	 *
	 *	@Description
	 *	식단 데이터를 변수와 배열에 모두 저장합니다.
	 */
	
	
	
	$breakfast = "아침식사";	
	
	
	$location 		= array();
	$time_foodcourt = array();
	$time_breakfast = array();
	$time_lunch		= array();
	$time_diner		= array();
	/*
	점심과 저녁을 합쳐놓은 2차원 배열,
	기숙사 식당의 경우는 아침, 점심, 저녁 순서의 2차원 배열
	배열에서 앞쪽 인덱스가 아침, 점심, 저녁,
	뒤 인덱스가 월, 화, 수, 목, 금에 해당함.	
	*/	
	$menu		= array();
	$price		= array();
	
	/*
	$lunch		= array();
	$diner		= array();
	$lunch_price= array();
	$diner_price= array();
	*/
	

	/* URL에서 restId 가 있는데, 1,2,3,4,5 가 각각 
	   교직원, 학생, 창업보육센터, 푸드코트, 창의인재원식당을 의미한다.
	*/
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_FAILONERROR, true);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	
	
	for ($restraunt_index = 0; $restraunt_index < 5; $restraunt_index++)
	{		
		$id = $restraunt_index+1;
		curl_setopt($curl, CURLOPT_URL, "https://m.hanyang.ac.kr/wlife/diet/diet001002.page?campusId=02&restId=0$id&apiUrl%5B%5D=%2FDHSH%2FA201300004.json");
		
		//echo "https://m.hanyang.ac.kr/wlife/diet/diet001002.page?campusId=02&restId=0$id&apiUrl%5B%5D=%2FDHSH%2FA201300004.json";
		
		$result = curl_exec($curl);	
		
		$result = preg_replace("#</div>#", ";", $result);		
		
		
		$result = preg_replace("#\<(/?[^\>]+)\>#", "\n", $result);
		$result = preg_replace("#\|+#", "\n", $result);		
		$result = preg_replace("#\|\s\|#", "\n", $result);
		$result = preg_replace("#[[:space:]]{2,}#", "\n", $result);
		
		$result = preg_replace("#;#", "|", $result);
		
		$result = preg_replace("#&nbsp\|#", ";", $result);		
		
		
		$pattern = "/위치.+/";
		preg_match($pattern, $result, $matches);
		if ( isset ($matches[0]) )
		{
			$location[$restraunt_index] = $matches[0];
		}
		// 교직원식당, 학생식당, 기숙사식당, 푸드코트, 창업보육센터 순서로
			// 0,1,2,3,4
		
		if ($restraunt_index != 3 )
		{		
		
			$time_breakfast[$restraunt_index] = get_full_time_by_time("조식", $result);
			$time_lunch[$restraunt_index] = get_full_time_by_time("중식", $result);
			$time_diner[$restraunt_index] = get_full_time_by_time("석식", $result);
			
			//echo 'i값: '.$i.'중식: '.$time_lunch[$i].'</br>';
			
			get_menu_in_time("조식", 0, $result, $restraunt_index);
			get_menu_in_time("중식", 1, $result, $restraunt_index);
			get_menu_in_time("석식", 2, $result, $restraunt_index);
			
			
		}
		else
		{
		/*
			if ($restraunt_index==3){
				echo "푸드코트</br>";
			}
			*/
		
			$time_foodcourt = get_foodcourt_time($result);
			get_menu_in_time("한식", 0, $result, $restraunt_index);
			get_menu_in_time("양식", 1, $result, $restraunt_index);
			get_menu_in_time("분식", 2, $result, $restraunt_index);
		}
		
	}
	
	curl_close($curl);
	
	
	
	function get_foodcourt_time($result)
	{
		$pattern = "/위치.+\\n\|\\n(.*?)/";
		preg_match($pattern, $result, $matches);
		if ( isset ($matches[1]) )
		{
			return $matches[1];
		}
		else
		{
			return "";
		}
	}
	
	
	function get_full_time_by_time($str_time, $source)
	{
		//$pattern = "/{$str_time}([^\|]){1,50}\|/";
		$pattern = "/{$str_time}(.{1,50})/";
		preg_match($pattern, $source, $matches);
		
		if ( count($matches) == 0 )
			return;
		
		$string = $matches[1];		
		if ($string !="")
		{
			$source = $string;
		}
		
		
		$pattern = "#[0-9]{2}:[0-9]{2}( )?~( )?[0-9]{2}:[0-9]{2}#";
		preg_match($pattern, $source, $matches);		
		if ( count($matches) == 0 )
			return;
		
		return $matches[0];
	}
	
	
	function get_menu_in_time($str_time, $time_index, $source, $restraunt_index)
	{	
		global $menu, $price;		
		
		
		$pattern = "#$str_time\\n\|\\n([^|]+)\|#";
		preg_match_all($pattern, $source, $matches);		
		
		/*
		if ($restraunt_index == 3){
			//echo "regex 패턴: $pattern</br>";
			//echo "원본</BR> $source</br>";
			//echo "matches: {$matches[1][0]}</br>";
		}
		*/
		
		$matches_size = count($matches);
		
		if ($matches_size==0)
			return;
		
		//echo "<p>matches_size: $matches_size</p>";
		
		// $j 는 각 요일의 각 시간당 몇 번째 메뉴인지와 연결됨		
		for ($day_index = 0; $day_index < 7; $day_index++)		
		//for ($day_index = 0; $day_index < 1; $day_index++)
		{		
			if ( !array_key_exists($day_index, $matches[1]) )
				continue;
		
		
			$string = $matches[1][$day_index];
			$word = explode("\n", $string);
			$menu_index = 0;
			for ($item_index = 0; $item_index < count($word); $item_index++)
			{				
				$string = $word[$item_index];				
				if ( is_price($string) )
				{
					$price[$restraunt_index][$time_index][$menu_index][$day_index] = $string;
					$menu_index++;
					/*
					if ($restraunt_index==3 && $day_index == 3)
					{
						echo '$string 값:'.$string.'</br>';
						echo '$restraunt_index 값:'.$restraunt_index.'</br>';
						echo '$time_index 값:'.$time_index.'</br>';
						echo '$menu_index 값:'.$menu_index.'</br>';
						echo '$day_index 값:'.$day_index.'</br>';
					}
*/					
				}
				else if ( $string == ";" )
				{
					$menu_index++;										
				}
				else
				{
					//if ( undefined_offset_in_4d_array($menu, $restraunt_index, $time_index, $menu_index, $day_index) )
//						continue;
					
					//$prev_value = $menu[$restraunt_index][$time_index][$menu_index][$day_index];					
					//if ( $prev_value == "" )
					if ( undefined_offset_in_4d_array($menu, $restraunt_index, $time_index, $menu_index, $day_index) )
					{									
						$menu[$restraunt_index][$time_index][$menu_index][$day_index] = $string;
						/*
						if ($restraunt_index==3 && $day_index == 3)
						{
							echo '$string 값:'.$string.'</br>';
							echo '$restraunt_index 값:'.$restraunt_index.'</br>';
							echo '$time_index 값:'.$time_index.'</br>';
							echo '$menu_index 값:'.$menu_index.'</br>';
							echo '$day_index 값:'.$day_index.'</br>';
						}
						*/
					}
					else
					{
						$prev_value = $menu[$restraunt_index][$time_index][$menu_index][$day_index];					
						$menu[$restraunt_index][$time_index][$menu_index][$day_index] =
							$prev_value." ".$string;						
					}
				}
			}
		}			
	}
	
	function is_price($string)
	{
	
		//echo "발견한 한 줄: ".$string."</br>";
		$pattern = "/^([0-9]+,)?[0-9]+$/";
		preg_match($pattern, $string, $matches);
		
		if ( count($matches) == 0 )
			return false;
		
		if ($matches[0] != "")
		{
			//echo "수 발견함</br>";
			return true;
		}	
		else
			return false;
	}
	
	function undefined_offset_in_4d_array($array_4d, $i, $j, $k, $l)
	{
		if ( 	isset($array_4d) && array_key_exists($i, $array_4d) == true 
			&&	isset($array_4d[$i]) && array_key_exists($j, $array_4d[$i]) == true 
			&&	isset($array_4d[$i][$j]) && array_key_exists($k, $array_4d[$i][$j]) == true 
			&&	isset($array_4d[$i][$j][$k]) && array_key_exists($l, $array_4d[$i][$j][$k]) == true 
			)
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	
	
	
	
  ?>