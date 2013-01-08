function collectFormDataAjax(form)
{
alert($(form).serialize() + " is the serialized form");	
	$.ajax
	({
		type: 'POST',
		url: 'RPC/WriteToDataBaseRPC.php' ,
		data: {formData: $(form).serialize()},
		success:	function(result)
		{
			$("#tooltip").html("Data successfully send to data base");
//			loadContent('RPC/DefaultViewRPC.php');

alert(result + " is the id returned " + $('[name="table"]', form).val());
if(result)
{
loadIsolatedContent(result, $('[name="table"]',this.form).val() );
}
else
{
alert('error collectFormDataAjax line 20');	
}
		},
		error: function()
		{
			$("#tooltip").html("Data could not be saved, wait a while and try again");	
			alert("Data could not be saved, wait a while and try again");	
		}
	});
}