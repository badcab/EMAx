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