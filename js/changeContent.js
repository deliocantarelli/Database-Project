$("#signupTab").click(function(){
	$("#signinTab").removeClass("active");
	$("#signinText").removeClass("login-active-tab-text");
	$("#signupTab").addClass("active");
	$("#signupText").addClass("login-active-tab-text");

	$("#jumbotron").html("");
	$("#jumbotron").load("html/signupContainer.php");
});
$("#signinTab").click(function(){
	$("#signupTab").removeClass("active");
	$("#signupText").removeClass("login-active-tab-text");
	$("#signinTab").addClass("active");
	$("#signinText").addClass("login-active-tab-text");

	$("#jumbotron").html("");
	$("#jumbotron").load("html/signinContainer.php");
});