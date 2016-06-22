


// JavaScript Document
function saveInformation(){

	var name = document.getElementById("name").value;
	var id = document.getElementById("id").value;
	var building = document.getElementById("building").value;
	var roomType = document.getElementById("roomType").value;
	var disability = document.getElementById("disability").value;
	var checks = document.getElementById("checks").value;
	var address = document.getElementById("address").value;
	var remark = document.getElementById("remark").value;

	alert(name+id+building+roomType+disability+address+remark);
	if(name=="" || id=="" || building=="" || checks=="" || roomType=="" || address=="")
	{
		alert(" 빈칸을 채워주시거나 박스를 선택하여 주십시요 ");
	}
	else
	{
		$.post("../student/Applying.php",{n:name,i:id,b:building,r:roomType,d:disability,a:address,r:remark},
		function(data){
			console.log(data);
			alert("성공적으로 저장되었습니다 ");
		});
	}
}

