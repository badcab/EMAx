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
function createNewUserSecondAJAX(userName, password)
{
	$.ajax
	({
		type: 'POST',
		url: 'RPC/CreateNewUser_WriteToDataBaseRPC.php',
		data: {userName: userName, password: password},
		success:	function(result)
		{
			$("#tooltip").html("New User " + userName + " added");
		},
		error: function()
		{
			alert("failed second ajax");	
		}
	});

}

function createNewUser()
{
	$.ajax
	({
		type: 'POST',
		url: 'RPC/CreateNewUserRPC.php' ,
		dataType: "html",
		success:	function(result)
		{
			$(result).dialog({										
				open: function()
				{
					
				},
				close: function()
				{
					$( this ).dialog( "destroy" );
				},
				closeOnEscape: true,
				draggable: false,
				title: 'Create User',
				width: 500,
				resizable: false,
				modal: true,
				buttons: 
				{
					'Add User': function() 
					{
						var userName = document.getElementById("userName");
						var password1 = document.getElementById("password1");
						var password2 = document.getElementById("password2");
						if(password1.value == password2.value)
						{
							createNewUserSecondAJAX(userName.value , password1.value);
						}
						else
						{
							alert(password1.value + " != " + password2.value);	
							password1.value = null;
							password2.value = null;
						}
						$( this ).dialog( "close" );
					}
				}
			});
		},
		error: function()
		{
			alert("error create new user");	
		}
	});
}
function loadChangePasswordModal()
{
	$.ajax
	({
		type: 'POST',
		url: 'RPC/ChangePasswordRPC.php' ,
		dataType: "html",
		success:	function(result)
		{
			$(result).dialog({										
				open: function()
				{
				},
				close: function()
				{
					$( this ).dialog( "destroy" );
				},
				closeOnEscape: true,
				draggable: false,
				title: 'Change Password',
				width: 400,
				resizable: false,
				modal: true,
				buttons: 
				{
					'Save': function() 
					{
						$.ajax
							({
								type: 'POST',
								url: 'RPC/ChangePasswordWriteRPC.php' ,
								data: {formData: $('form', this).serialize()},
								dataType: "html",
								success:	function(result)
								{
									alert(result);
								},
								error: function()
								{
									alert("password not changed");	
								}
							});					
						$( this ).dialog( "close" );
					}
				}
			});
		},
		error: function()
		{
			alert("error change password");	
		}
	});
}
/* we will need to objectify this */
