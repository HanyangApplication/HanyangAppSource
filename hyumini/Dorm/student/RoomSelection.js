


// JavaScript Document
function inputdb(){
	
    	
   
	var room = document.getElementById("room").value;
	var building = document.getElementById("building").value;
	var roomType = document.getElementById("roomType").value;
	var id = document.getElementById("id").value;
	var name = document.getElementById("name").value;

	if(name=="" || id=="" || building=="" || roomType=="" || room=="")
	{
		alert(" 빈칸을 채워주시거나 박스를 선택하여 주십시요 ");
	}
	else
	{	
		
		/*var checkRoom = function() {
		postData = {n:name, i:id, b:building, rt:roomType, r:room};
	$.ajax({
		type: 'POST',
		url: "../student/RoomSelection.php",
		data: postData,
		success : function(result){
			alert("제출하였습니다");
		
		 alert("성공적으로 저장되었습니다 ");
		}
	});*/

		$.post("../student/RoomSelection.php",{n:name, i:id, b:building, rt:roomType, r:room},
		function(data){
			console.log(data);
			alert("Data is succesed!");
		});
		
	}	

	
}

