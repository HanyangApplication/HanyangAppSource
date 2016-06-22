/*
	Author: Zhiqiang Wu
	Date:June 20, 2016
*/
$(document).ready(function() {
	/*----search form event start.----*/
	//call search() if check form past 
    $("#searchInfomation").validate({
		rules : {
			in_id : {
				digits:true
			}
		},
		messages : {
			in_id : {
				digits:"digits only"
			}
		},
		submitHandler: function() {
			search();
		},
    });
    /*----search form event end.----*/

    /*----update data form event start.----*/
    //call updateBoot() if check form past
	$("#stdinfo").validate({
		rules : {
			name:{
				required:true
			},
			id:{
				required:true,
				digits:true
			},
			dorm:{
				required:true
			},
			room:{
				required:true
			}
		},
		submitHandler: function() {
			updateBoot();
		},
    });
    /*----update data form event end.----*/

    var id = getUrlParam("id"); 
    console.log(id);
    if (id != null) {
    	$("input[name='in_id']").val(id);
    	 $("#searchInfomation").submit();
    }
});


/*
*Search studnets information, 
*and call different function to handle different number result(s).
*/
var search = function() {
	var postData = $("#searchInfomation").serialize(); 

	$.ajax({
		type: 'POST',
		url: "../manager/php/modify.php",
		data: postData,
		success : function(result){
			if (result.status == 200)	{
				$dataNumber = $(result.data).size();
				if ($dataNumber == 0) {
					alert("Not find such ID or Name.");
					return;
				}else if ($dataNumber > 1){
					loadModal(result.data);//show select person modal if have many record.
				}else {
					showOneData(result.data[0]);//load this person infomartion if only one record.
				}
			}else {
				alert(result.message);
			}
		},
		dataType: "json",
	});
}

/*
*bootstrap of update(), call checkroom() to check if room enabled,
*if check past checkroom() function will call update() to really update one data.
*/
var updateBoot = function() {
	checkRoom();
}

/*
*Update studnet information.
*this function is a callback function of checkroom(),
*if not check room first maybe will cause an database error,
*because of every room only accommodate two person.
*/
var update = function() {
	var postData = $("#stdinfo").serialize(); 

	$.ajax({
		type: 'POST',
		url: "../manager/php/modify.php",
		data: postData,
		success : function(result){
			if (result.status == 200)	{
				alert(result.message);
			}else {
				alert(result.message);
			}
		},
		dataType: "json",
	});
}

/*
*Show all person in modal if have many record.
*Param: data--all person array.
*callback: call bindDataSelect() bind button event
*callback: show modal
*/
var loadModal = function(data) {
	var $modal = $("#infoModalBody");
	$modal.empty();
	var $table = $("<table>").addClass("table table-striped table-bordered table-condensed");
	var thead = "<thead><tr><th>Name</th><th>ID</th><th>Building</th><th>Room</th><th>Select</th></tr></thead>";
	$table.append(thead);
	$(data).each(function(index, value) {
		var $tr = $("<tr>");
		$tr.append("<td>"+value.name+"</td>");
		$tr.append("<td>"+value.id+"</td>");
		$tr.append("<td>"+value.building+"</td>");
		$tr.append("<td>"+value.room+"</td>");
		$tr.append("<td><button class='select-one' data-id="+value.id+">Edit</button></td>");

		$table.append($tr);
	});
	$modal.append($table);

	bindDataSelect();//bind all button click event.
	$("#infoModal").modal("show");
}

/*
*bind all button click event.
*bind complete callback: none
*bind event callback: show this person data.
*bind event callback: hide modal.
*/
var bindDataSelect = function() {
	$(".select-one").bind("click", function() {
		var $tds = $(this).parent().parent().children();
		var oneData = {
			'name'	: $tds[0].innerText,
			'id'	: $tds[1].innerText,
			'building'	: $tds[2].innerText,
			'room'	: $tds[3].innerText,
		};
		showOneData(oneData);//show this person data.
		$("#infoModal").modal("hide");//hide modal.
	});
}

/*
*Show new data.
*Param: data.
*/
var showOneData = function(data) {
	//console.log(data);
	$("input[name='in_name']").val(data.name);
	$("input[name='in_id']").val(data.id);
	$("input[name='name']").val(data.name);
	$("input[name='id']").val(data.id);
	$("input[name='room']").val(data.room);
}

/*
*bootstarp function of update(),
*if check past call update()
*else call loadModal() to edit people information or point error.
*/
var checkRoom = function() {
	postData = {
		"action" : "checkroom",
		"room"	 : $("input[name='room']").val(),
		"id"	 : $("input[name='id']").val(),
	};
	$.ajax({
		type: 'POST',
		url: "../manager/php/modify.php",
		data: postData,
		success : function(result){
			if (result.status == 200)	{
				var dataNumber = $(result.data).size();
				if (dataNumber < 2) {
					update();
				}else {
					var ifEditClash = confirm("There ara aleardy "+dataNumber+" people live in room "+result.data[0].room+", if show these "+dataNumber+" people's information?");
					if (ifEditClash) {
						loadModal(result.data);
					}else {
						var $label = '<label id="room-error" class="error" for="room">This room is disabled.</label>';
						$("input[name='room']").after($label);
						return ;
					}
				}
			}else {
				alert(result.message);
			}
		},
		dataType: "json",
	});
}

//获取url中的参数
function getUrlParam(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
    var r = window.location.search.substr(1).match(reg);  //匹配目标参数
    if (r != null) return unescape(r[2]); return null; //返回参数值
}