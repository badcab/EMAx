function optionHiddenForPrint(formOfID)
{
	if(formOfID != '')
	{
//		$('#optionShowPrint').css('display', 'block');
		$('#optionShowPrint').val(hiddenForPrintPrivate(formOfID, 'Option'));
	}
}
function gradeHiddenForPrint(formOfID)
{
	if(formOfID != '')
	{
		$('#gradeShowPrint').val(hiddenForPrintPrivate(formOfID, 'Grade'));
	}
}
function hiddenForPrintPrivate(IDstring, tableName)
{
	var formatedString = tableName + "s Selected: None";
	$.ajax
	({
		type: 'POST',
		url: 'RPC/HiddenPrintRPC.php' ,
		data: {ids: IDstring, table: tableName},
		success:	function(result)
		{
			formatedString = tableName + "s Selected: " + result;
alert(formatedString);
		},
		error: function()
		{
			alert('error add ' + tableName);
		}
	});
	return formatedString;
}
