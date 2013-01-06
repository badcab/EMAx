//$('html').keypress(function(e) {
//    if(e.which == 13) 
//    {
//      alert('You pressed enter! loginscript');
//		loginScript();
//    }
//});

function loginScript()
{
	var user = $("#userName").val();
	var password = $("#password").val();

	$.ajax
	({
  		type: "POST",
  		url: "RPC/LoginCheckRPC.php",
//   	data: { user: user.value, password: password.value },
data: { user: 'mike', password: 'blizzard' },
 		dataType: "html",
		success:	function(result)
		{
			$("#content").html("");
			if(result != "FALSE")
			{
				var DefaultViewDiv = loadContent('RPC/DefaultViewRPC.php');
				$(".isLogin").show( "fold", 1000,function() {
					$("#content").html(DefaultViewDiv);
					$("#userStatus").html(
						result
						+ " <input type='button' id='changePasswordButton' value='Change Password' onclick='loadChangePasswordModal()' />" 
					);
				});
				$("#tooltip").html("This is a list of upcoming events");
			}
			else
			{
				password.value = null;
				alert("check your user name and password and try again")
			}
		},
		error: function()
		{
			alert("Login Failed");		
		}
	});	
}

