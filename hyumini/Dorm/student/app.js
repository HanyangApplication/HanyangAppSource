

function saving(){
	var name = document.getElementById("name").value;
	var id = document.getElementById("id").value;
	var building = document.getElementById("building").value;
	var roomType = document.getElementById("roomType").value;
	var disability = document.getElementById("disability").checked;
	var checks = document.getElementById("checks").checked;
	var address = document.getElementById("address").value;
	var remark = document.getElementById("remark").value;

	//alert(name+" "+id+" "+building+" "+roomType+" "+disability+" "+checks+" "+address+" "+remark);
	if(name=="" || id=="" || building=="" || checks=="" || roomType=="" || address=="")
	{
		alert(" 빈칸을 채워주시거나 박스를 선택하여 주십시요 ");
	}
	else
	{		

		$.post("../app.php",{n:name, i:id, b:building, r:roomType, d:disability, a:address, re:remark},
		function(data){
			console.log(data);
			alert("Data is succesed!");
		});
	}
  }
			
	


