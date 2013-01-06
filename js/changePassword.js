function changePassword(oldPass, newPass)//do i even use this?
{
	
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