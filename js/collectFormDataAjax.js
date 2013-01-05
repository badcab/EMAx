function collectFormDataAjax(form)
{
	$.ajax
	({
		type: 'POST',
		url: 'RPC/WriteToDataBaseRPC.php' ,
		data: {formData: $(form).serialize()},
//add some shit here "result" to get id
		success:	function()
		{
			$("#tooltip").html("Data successfully send to data base");
			loadContent('RPC/DefaultViewRPC.php');
//loadIsolatedContent(result, $('[name="table"]',form.val()) )
		},
		error: function()
		{
			$("#tooltip").html("Data could not be saved, wait a while and try again");	
			alert("Data could not be saved, wait a while and try again");	
		}
	});
}