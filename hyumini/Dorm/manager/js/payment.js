$(document).ready(function() {
	loadInfo();
});

var payArr = new Array();
payArr.push("No", "YES");

var btnArr = new Array();
btnArr.push("danger", "success");

/*
*get payment data when page load complete.
*/
var loadInfo = function(page = 1) {
	var leftArr = '<a data-type="p" target="_self"><span><span class="glyphicon glyphicon-triangle-left"></span>Previous Page</span></a>';
    var rightArr = '<a data-type="n" target="_self"><span>Next Page<span class="glyphicon glyphicon-triangle-right"></span></span></a>';

	var Param = {
		"action": "list",
		"page"	: page,
		"col"	: 10
	};

	$.ajax({
		type: 'GET',
		url: "../manager/php/payment.php",
		data: Param,
		success : function(result){
			if (result.status == 200) {
				$(".page-control").attr("data-page", page);
				$(".page-control").attr("data-max", result.pages_tot);
				$(".page-control").empty();
				if (page > 1) {
					$(".page-control").append(leftArr);
				}
				if (page < result.pages_tot) {
					$(".page-control").append(rightArr);
				}
				showData(result.data);
			}else {
				alert(result.message);
			}
		},
		dataType: "json",
	});
}

/*
*callback: bind page turn button event
*callback: bind page action button event
*/
var showData = function(data) {
	$("tbody").empty();

	$(data).each(function(index, item) {
		var $tr = $("<tr>\
				<td>"+item.name+"</td>\
				<td>"+item.id+"</td>\
				<td>"+item.building+"</td>\
				<td>"+item.room+"</td>\
				<td><div class='btn-group'><button style='width:65px' class='btn btn-"+btnArr[Number(item.payment)]+
				" dropdown-toggle disabled' data-toggle='dropdown'\
				 aria-haspopup='true' aria-expanded='false'> "+payArr[Number(item.payment)]+" <span class='caret'></span></button></div></td>\
				<td><button class='btn btn-default button-action'>Change</button>\
			</tr>");


		var $ul = $("<ul class='disabled' disabled='disabled'>");
		var $btnGroup = $($($tr.children()[4]).children());

		var $ul = $("<ul class='dropdown-menu'>");
		for (var i = 0; i <  2; i++) {
			var $li = $("<li class='value-item'><a>"+payArr[i]+"</a></li>");
			$li.attr({"data-id":item.id, "data-value":i});
			if (Number(item.payment) === i) {
				$li.attr("selected", "selected");
			}
			$ul.append($li);
		}
		$btnGroup.append($ul);

		$("tbody").append($tr);
	});
	bindPageTurn();
	bindActionButton();
}

/*
*nothing.
*/
var bindPageTurn = function() {
	$(".page-control a").bind("click", function() {
		var page 	 = Number($(".page-control").attr("data-page"));
		var pageMax  = Number($(".page-control").attr("data-max"));
		var pageType = $(this).attr("data-type");
		
		if (pageType == "p") {
			if (page > 1) {
				loadInfo(page - 1);
			}else {
				alert("Already first page.");
			}
		}else {
			if (page < pageMax) {
				loadInfo(page + 1);
			}else {
				alert("Already last page.");
			}
		}
	});
}
	

var bindActionButton = function() {
	$(".button-action").bind("click", function() {
		var btnGroup = $(this).parent().parent().children(4).children();
		var $valueButton = btnGroup.children("button");
		$valueButton.removeClass("disabled");

		if($(this).text() == "Save") {
			
			if ($valueButton.attr("data-id") == null) {
				alert("No value have changed.");
			}else {
				var itemId = $valueButton.attr("data-id");
				var itemValue = $valueButton.attr("data-value")
				updateData({"id":itemId, "value":itemValue});
				$valueButton.removeAttr("data-id");
				$valueButton.removeAttr("data-value");
				$valueButton.removeClass("btn-success btn-danger");
				$valueButton.addClass("btn-"+btnArr[itemValue]);
			}

			$(this).removeClass("btn-primary");
			$(this).addClass("btn-default");
			$(this).text("Change");
			$valueButton.addClass("disabled");
		}else {
			$(this).removeClass("btn-default");
			$(this).addClass("btn-primary");
			$(this).text("Save");
		}
	});

	$(".value-item").bind("click", function() {
		$button = $(this).parent("ul").parent("div").children("button");
		$button.html($(this).text()+" <span class='caret'></span>");
		//console.log($(this).val());
		$button.attr({"data-id": $(this).attr("data-id"), "data-value": $(this).attr("data-value")});
	});
}

/*
*update data.
*param: an array, {"id":, "value"}
*param: arr['id'] is student ID, arr['value'] is this studuent payment information.
*/
var updateData = function(data) {
	data["action"] = "update";
	$.ajax({
		type: 'POST',
		url: "../manager/php/payment.php",
		data: data,
		success : function(result){
			if (result.status == 200) {
				alert(result.message);
			}else {
				alert(result.message);
			}
		},
		dataType: "json",
	});
}