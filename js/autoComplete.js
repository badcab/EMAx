function autoCompleteCity()
{   
	$.ajax
	({
		type: 'POST',
		url: "RPC/AutoCompleteCityRPC.php" ,
		dataType: "html",
		success:	function(result)
		{
			$( "#city" ).autocomplete({
				source: result.split(",")
			});
		}
	});	
}

function autoCompleteSearch()
{    
	$.ajax
	({
		type: 'POST',
		url: "RPC/AutoCompleteSearchRPC.php" ,
		dataType: "html",
		success:	function(result)
		{
			$( "#search" ).autocomplete({
				source: result.split(",")
			});
		}
	});

}
