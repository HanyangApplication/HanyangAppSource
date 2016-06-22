/*
	 *	Author: 성다혜, 김진희
	 *
	 *	@Description
	 *	페이지가 열렸을 때 보여지는 것과,
	 *	페이지 내에 각 버튼을 눌렀을 때의 동작을 설정합니다.
	 *
	 *
	 *	16 ~ 45줄, 218 ~ 236줄: 성다혜
	 *	46 ~ 216줄: 김진희	 
	 */




$(document).ready(function()
{
	$(".menu").hide();

    $(".studentResInfo").hide();
    $(".staffResInfo").hide();
    $(".FCInfo").hide();
    $(".DormResInfo").hide();
    $(".StartupResInfo").hide();


	/*
	clilked-res toggle 테스트 코드
	toggle 전
	var class_strings = this.getAttribute("class");
		alert(class_strings);
	toggle 후
		class_strings = this.getAttribute("class");
		alert(class_strings);
	*/

    $(".studentRes").click(function(){
        $(".studentResInfo").toggle();
		this.classList.toggle('cliked-res');
    });
    $(".staffRes").click(function(){
        $(".staffResInfo").toggle();
		this.classList.toggle('cliked-res');
    });
    $(".FC").click(function(){
        $(".FCInfo").toggle();
		this.classList.toggle('cliked-res');
    });
    $(".DormRes").click(function(){
        $(".DormResInfo").toggle();
		this.classList.toggle('cliked-res');
    });
    $(".StartupRes").click(function(){
        $(".StartupResInfo").toggle();
		this.classList.toggle('cliked-res');
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
					var class_strings = this.getAttribute("class");
					//alert(class_strings);

					var button_string = "btn_"+string+"_";
					var regex = new RegExp(button_string+"[0-9]");
					var arr = class_strings.match(regex);
					var class_string = arr[0];
					//alert(class_string);

					set_button_cliked(this);
					class_strings = this.getAttribute("class");
					//alert(class_strings);
					var value = class_string.charAt(class_string.length - 1);
					set_array_values(array, value);
					show_and_hide_contents();
					show_and_hide_foodcourt_contents();
				}
			);
		}
	}


	function set_button_cliked(button) {

		var array = $(".btn");
		for (var i = 0; i < array.length; i++) {
			array[i].classList.remove('cliked');
		}
		button.classList.add('cliked');
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
					//alert("보여줘야 하는 것: .menu"+i+j);
					//$('a').removeClass('Highlight');
					$(".btn_time_"+i).addClass('Highlight');
					$(".btn-group .btn_day_"+j).addClass('btn-success');
				}
				else
				{
					$(".menu"+i+j).hide();
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

	$('.btn-group button').click(function(){
		$('.btn-group button').removeClass('btn-success');
		$('.btn-group button').addClass('btn-default');
		$(this).removeClass('btn-default');
		$(this).addClass('btn-success');
	});

	$('a').click(function(){
		$('a').removeClass('Highlight');
		$(this).addClass('Highlight');
		$(".studentResInfo").hide();
		$(".staffResInfo").hide();
		$(".FCInfo").hide();
		$(".DormResInfo").hide();
		$(".StartupResInfo").hide();
	});


  });
