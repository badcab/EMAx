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

//alert(result + " is the id returned " + $('[name="table"]', form).val());
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