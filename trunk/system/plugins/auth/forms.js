function register()
{
	$.ajax({
		type: "GET",
		url: "register.php",
		data: 	"username=" + document.getElementById("username").value + 
				"&email=" + document.getElementById("email").value + 
				"&pass=" + document.getElementById("pass").value + 
				"&cpass=" + document.getElementById("cpass").value,
		success: function(html){
			$("#response").html(html);
		}
	});
}