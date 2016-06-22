/*
	Author: Zhiqiang Wu
	Date:June 20, 2016
*/
$(document).ready(function() {
	loadData();//load new data when page loaded completed.

	//validate that is the form data filled.
    $("form").validate({
		rules : {
			year : {
				required:true,
				digits:true,
				minlength:4,
				maxlength:4
			},
			period : {
				required:true,
			},
			begin : {
				required:true,
				dateISO:true
			},
			due : {
				required:true,
				dateISO:true
			},
		},
		messages : {
			year : {
				required:"Year is required.",
			},
			period : {
				required:"Period is required.",
			},
			begin : {
				required:"Begin Date is required.",
			},
			due : {
				required:"End Date is required.",
			},
		},
		submitHandler: function(form) {
			var postData = $("form").serialize(); 

			$.ajax({
				type: 'POST',
				url: "../manager/php/period.php",
				data: postData,
				success : function(result){
					if (result.status == 200)	{
						alert(result.message);
						loadData();//Load new data.
					}else {
						alert("Request error, please retry.");
					}
				},
				dataType: "json",
			});
		},
    });
});

/*
*Load new data, call this function when page loaded or updated data.
*Param: none.
*callback: function showData();
*/
var loadData = function() {
	$.ajax({
		type: 'GET',
		url: "../manager/php/period.php?peioid=1",
		success : function(result){
			if (result.status == 200)	{
				showData(result.data);
			}else {
				alert("Request data error.");
			}
		},
		dataType: "json",
	});
}

/*
*Show new data.
*Param: data.
*/
var showData = function(data) {
	//console.log(data);
	$("input[name='year']").val(data.year);
	$("input[name='period']").val(data.period);
	$("input[name='begin']").val(data.begin);
	$("input[name='due']").val(data.due);
}