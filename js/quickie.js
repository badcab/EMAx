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

function datepicker()
{
	$( "#datepicker" ).datepicker();
}

function reloadTabs()
{
	$( "#tabs" ).tabs();
}

$("html").on({
    ajaxStart: function() 
    { 
        $(this).addClass("loading");
    },
    ajaxStop: function() 
    { 
        $(this).removeClass("loading"); 
    }    
});