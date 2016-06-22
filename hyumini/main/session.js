/*
	모든 페이지에서 사옹할 세션 체크용 js페이지입니다.
	동기화의 문제로 적용하진 않았습니다.
	author 송형석
*/

var master, name, email, SID;
Event.observe(window, "ready", function(){
new Ajax.Request("session.php", {
		    method: "post",
		    async: true, 
			onSuccess: parseSession,
			onFailure: ajaxFailed,
			onException: ajaxFailed,
		});


function parseSession(ajax) {
	var data = JSON.parse(ajax.responseText);
	SID = data.studentInfo.SID;
	name = data.studentInfo.name;
	email = data.studentInfo.email;
	master = data.studentInfo.master;
}

function ajaxFailed(ajax, exception) {
	var errorMessage = "Error making Ajax request:\n\n";
	if (exception) {
		errorMessage += "Exception: " + exception.message;
	} else {
		errorMessage += "Server status:\n" + ajax.status + " " + ajax.statusText + 
		                "\n\nServer response text:\n" + ajax.responseText;
	}
	location.href = "./login/login.html";
}
});