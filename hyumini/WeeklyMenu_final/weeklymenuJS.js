$(document).ready(function()
{
	//var no_hide_time = ".breakfast";
	//var no_hide_day = ".mon";
	
	$(".menu").hide();	
	
	//alert(day_index);

    $(".studentResInfo").hide();
    $(".staffResInfo").hide();
    $(".FCInfo").hide();
    $(".DormResInfo").hide();
    $(".StartupResInfo").hide();

    $(".studentRes").click(function(){
        $(".studentResInfo").toggle();
    });
    $(".staffRes").click(function(){
        $(".staffResInfo").toggle();
    });
    $(".FC").click(function(){
        $(".FCInfo").toggle();
    });
    $(".DormRes").click(function(){
        $(".DormResInfo").toggle();
    });
    $(".StartupRes").click(function(){
        $(".StartupResInfo").toggle();
    });
	
	
	
	var timeShowArray = new Array(3);
	var dayShowArray = new Array(7);
	
	var foodcourtShowArray = new Array(3);
	
	var today = new Date();
	
	// 일요일이 0임
	var day = today.getDay();	
	// 월요일을 0으로
	var day_index = (day+6)%7;
	
	var hour = today.getHours();
	var minute = today.getMinutes();
	
	//alert(hour);
	//alert(minute);
	
	
	set_array_control_buttons(timeShowArray, "time");
	set_array_control_buttons(dayShowArray, "day");
	set_array_control_buttons(foodcourtShowArray, "foodcourt");
	
	
	// 오늘 것을 기본으로 보여줌
	dayShowArray[day_index] = true;
	//alert(day_index);
	
	// 푸드코트는 한식을 기본으로 보여줌
	foodcourtShowArray[0] = true;
	$(".foodcourt0").show();
	
	
	// 주말에는 오전 9시 전까지는 아침을 보여줌
	if ( day_index >= 5 && hour <= 9 )
	{
		// 아침
		timeShowArray[0] = true;		
	}	
	// 오후 1시 30분 전까지는 점심을, 그 이후로는 저녁을 기본으로 보여줌	
	else if ( (hour <= 13 && minute <= 30) || hour <= 12 )
	{
		// 점심
		timeShowArray[1] = true;
	}
	else
	{
		// 저녁
		timeShowArray[2] = true;		
	}
	
	if ( day_index >= 5 )
	{
		$(".DormResInfo").show();
	}
	
	
	show_and_hide_contents();
	show_and_hide_foodcourt_contents();	
	
	
	function set_array_control_buttons(array, string)
	{	
		for ( var i = 0; i < array.length; i++ )
		{
			array[i] = false;
			
			$(".btn_"+string+"_"+i).click
			(
				function ()
				{
					var string = this.getAttribute("class");
					var value = string.charAt(string.length - 1);
					set_array_values(array, value);
					show_and_hide_contents();
					show_and_hide_foodcourt_contents();
				}
			);			
		}		
	}
	
	
	function set_array_values(array, i)
	{		
		for ( var j = 0; j < array.length; j++ )
		{
			if ( i == j )
			{
				array[j] = true;
			}
			else
			{
				array[j] = false;
				//alert("i값: "+i);
			}
		}
	}
	
	
	// 요일과 시간 값이 모두 true인 경우만 보여주고,
	// 나머지는 감춤
	function show_and_hide_contents()
	{
		for ( var i = 0; i < timeShowArray.length; i++ )
		{
			for ( var j = 0; j < dayShowArray.length; j++ )
			{
				if ( (timeShowArray[i] == true) && (dayShowArray[j] == true) )
				{
					$(".menu"+i+j).show();
					//$(".menu"+i+j).show();
					//alert("보여줘야 하는 것: .menu"+i+j);
				}
				else
				{
					//$(".menu"+i+j).show();
					$(".menu"+i+j).hide();
					//$(".menu"+i+j).show();
				}				
			}		
		}
	}
	
	
	
	function show_and_hide_foodcourt_contents()
	{
		for ( var i = 0; i < foodcourtShowArray.length; i++ )
		{
			if ( foodcourtShowArray[i] == true)
			{
				$(".foodcourt"+i).show();
			}
			else
			{
				$(".foodcourt"+i).hide();
			}		
		}
	}
	
	
  });
