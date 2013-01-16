//we should rename this file to be more fitting for what it now is
function collectFormDataAjax(form)
{
	$.ajax
	({
		type: 'POST',
		url: 'RPC/WriteToDataBaseRPC.php' ,
		data: {formData: $(form).serialize()},
		success:	function(result)
		{
			$("#tooltip").html("Data successfully send to data base");

			if(result)
			{
				loadIsolatedContent(result, $('[name="table"]',this.form).val() );
			}
			else
			{
				alert('error data not saved, make sure you filled everything out something proper!');
				$("#tooltip").html('error data not saved, make sure you filled everything out something proper!');	
			}
		},
		error: function()
		{
			$("#tooltip").html("Data could not be saved, wait a while and try again");	
			alert("Data could not be saved, wait a while and try again");	
		}
	});
}
function clearFormData(form)
{
	$.ajax
	({
		type: 'POST',
		url: 'RPC/DeleteFromDataBaseRPC.php' ,
		data: {formData: $(form).serialize()},
		success:	function()
		{
			$("#tooltip").html("Data successfully removed");
			loadContent('RPC/DefaultViewRPC.php');

		},
		error: function()
		{
			$("#tooltip").html("Data could not be deleted, wait a while and try again");	
			alert("Data could not be deleted, wait a while and try again");	
		}
	});
}

