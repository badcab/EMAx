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
