/*
	Author: Zhiqiang Wu
	Date:June 20, 2016
*/
$(document).ready(function() {
	/*bind page return event start*/
	$(".page-control a").bind("click", function() {
		var pageType = $(this).attr("data-type");
		var pageNow = $("input[name='page']").val();
		if (pageType == "p") {
			if (pageNow == 1) {
				alert("Already first page.");
				return ;
			}
			$("input[name='page']").val(Number(pageNow) - 1);
		}else { 
			$("input[name='page']").val(Number(pageNow) + 1);
		}
		$("form").submit();
	});
	/*bind page return event end*/

	/*bind search form return event start*/
	$("#search").bind("click", function() {
		$("input[name='page']").val(1);
		$("form").submit();
	});
	/*bind search form return event end*/

	/*bind editor button event start*/
	$(".btn-edit").bind("click", function() {
		window.location.href = "./modify.html?id=" + $(this).parent().parent().find("input[data-id]").attr("data-id");
	});
	/*bind editor button event end*/
	init();
});


var reInit = function() {
	$(".btn-reject").unbind();
	$(".btn-accept").unbind();
	$(".reject-all").unbind();
	$(".accept-all").unbind();

	init();
}

var init = function() {

	/*bind one item data reviem event start*/
	$(".btn-reject").bind("click", function() {
		var data = new Array();
		data.push($(this).parent().parent().find("input[data-id]").attr("data-id"));
		review(data, "reject");
	});
	$(".btn-accept").bind("click", function() {
		var data = new Array();
		data.push($(this).parent().parent().find("input[data-id]").attr("data-id"));
		review(data, "accept");
	});
	/*bind one item data reviem event end*/

	/*bind many items data reviem event start*/
	$(".reject-all").bind("click", function() {
		var $checkboxs = $("input[type=checkbox]:checked");
		var data = new Array();
		$checkboxs.each(function(index, item) {
			data.push(item.getAttribute("data-id"));
		});
		review(data, "reject");
	});
	$(".accept-all").bind("click", function() {
		var $checkboxs = $("input[type=checkbox]:checked");
		var data = new Array();
		$checkboxs.each(function(index, item) {
			data.push(item.getAttribute("data-id"));
		});
		review(data, "accept");
	});
	/*bind many items data reviem event start*/
} 

/*
*Param: data: an array
*Param: method: {"accept","reject"}
*/
var review = function(data = "", method = "") {
	var postData = {
		"action" : method,
		"data"	 : data,
	};

	$.ajax({
		type: 'POST',
		url: "../manager/php/view.php",
		data: postData,
		success : function(result){
			if (result.status == 200 || result.status == 205)	{
				if (method == "reject") {
					$(data).each(function(index, item) {
						var $thistr = $("input[data-id='"+item+"']").parent().parent().parent("tr");
						$thistr.find(".btn-reject").removeClass("btn-reject btn-danger").addClass("btn-accept btn-success").text("Accept");
						$thistr.children()[5].innerText = "Rejected";
						$("input[type=checkbox]:checked").removeAttr("checked");
					});
				}else if (method == "accept") {
					var nowData = Array.minus(data, result.error_data);

					$(nowData).each(function(index, item) {
						var $thistr = $("input[data-id='"+item+"']").parent().parent().parent("tr");
						$thistr.find(".btn-accept").removeClass("btn-accept btn-success").addClass("btn-reject btn-danger").text("Reject");
						$thistr.children()[5].innerText = "Assigned";
						$("input[type=checkbox]:checked").removeAttr("checked");
					});

					$(result.error_data).each(function(index, item) {
						console.log(item);
						var $thistr = $("input[data-id='"+item+"']").parent().parent().parent("tr");
						console.log($thistr);
						$thistr.children()[5].innerText = "Discordant";
						$("input[type=checkbox]:checked").removeAttr("checked");
					});
				}else {
					alert("Some error happend.");
					return ;
				}
				alert(result.message);
				
			}else {
				alert(result.message);
			}
			reInit();
		},
		dataType: "json",
	});

}

//数组功能扩展
Array.prototype.each = function(fn){  
    fn = fn || Function.K;  
     var a = [];  
     var args = Array.prototype.slice.call(arguments, 1);  
     for(var i = 0; i < this.length; i++){  
         var res = fn.apply(this,[this[i],i].concat(args));  
         if(res != null) a.push(res);  
     }  
     return a;  
}; 
//数组是否包含指定元素
Array.prototype.contains = function(suArr){
    for(var i = 0; i < this.length; i ++){  
        if(this[i] == suArr){
            return true;
        } 
     } 
     return false;
}
//不重复元素构成的数组
Array.prototype.uniquelize = function(){  
     var ra = new Array();  
     for(var i = 0; i < this.length; i ++){  
        if(!ra.contains(this[i])){  
            ra.push(this[i]);  
        }  
     }  
     return ra;  
};

//求差集
Array.minus = function(a, b){ 
	return a.uniquelize().each(function(o){return b.contains(o) ? null : o});  
}; 