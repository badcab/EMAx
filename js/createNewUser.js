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