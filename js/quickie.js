//may need to rename etera or something
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

function miscellaneousScript(tableName, Action, stringValue, cost)
{
	cost = typeof cost !== 'undefined' ? cost : 'none' ;
	$.ajax
	({
		type: 'POST',
		url: 'RPC/MiscellaneousWriteRPC.php' ,
		data: {tableName: tableName, Action: Action, stringValue: stringValue, cost: cost},
		success:	function()
		{
			loadContent('RPC/MiscellaneousRPC.php');
			$("#tooltip").html("Add and remove various things");
		},
		error: function()
		{
			alert("it failed miscellaneous");	
		}
	});
}
function checkBoxFix(field, idOfHiddenInput)
{
	if(field.checked)
	{	
		$('#' + idOfHiddenInput).val(1);
	}	
	else
	{
		$('#' + idOfHiddenInput).val(0);
	}
}
function SearchByDate(checkBox)
{
	if($(checkBox).prop("checked"))
	{
		$( "#search" ).val('');
		$( "#search" ).datepicker();
		$( "#search" ).autocomplete({ disabled: true });
	}
	else
	{
		$( "#search" ).val('');
		$( "#search" ).datepicker( "destroy" );
		autoCompleteSearch();
		$( "#search" ).autocomplete({ disabled: false });
	}
}
