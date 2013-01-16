function hiddenForPrint(table)
{
	if(table == 'Option')
	{
		optionHiddenForPrint();
	}
	
	if(table == 'Grade')
	{
		gradeHiddenForPrint();
	}
}
function eventAddOption()
{
	unifiedEventAdd('Option', 'optionEventMapHiddenText');
}
function optionHiddenForPrint()
{
	if($('#optionEventMapHiddenText').val() != '')
	{		
		hiddenForPrintPrivate($('#optionEventMapHiddenText').val(), 'Option', 'optionShowPrint');
	}
}
function eventAddGrade()
{
	unifiedEventAdd('Grade', 'gradeEventMapHiddenText');	
}
function gradeHiddenForPrint()
{
	if($('#gradeEventMapHiddenText').val() != '')
	{
		hiddenForPrintPrivate($('#gradeEventMapHiddenText').val(), 'Grade', 'gradeShowPrint');
	}
}
function hiddenForPrintPrivate(IDstring, tableName, IDtarget)
{
	$('#' + IDtarget ).html(tableName + "s Selected: none");
	$.ajax
	({
		type: 'POST',
		url: 'RPC/HiddenPrintRPC.php' ,
		data: {ids: IDstring, table: tableName},
		success:	function(result)
		{
			$('#' + IDtarget ).html(tableName + "s Selected: " + result);
		},
		error: function()
		{
			$('#' + IDtarget ).html(tableName + "s Selected: Error");
		}
	});
}
function unifiedEventAdd(tableName, writeTargetHiddenID)
{
	$.ajax
	({
		type: 'POST',
		url: 'RPC/' + tableName + 'TableRPC.php' ,
		dataType: "html",
		success:	function(result)
		{
			$(result).dialog({										
				open: function()
				{
					var alreadyChecked = $('#' + writeTargetHiddenID ).val();
					var alreadyCheckedArr = alreadyChecked.split(",");
					for (var i=0;i<alreadyCheckedArr.length;i++)
					{ 
						$('input[name=' + alreadyCheckedArr[i] + ']').prop('checked', true);
					}	
				},
				close: function()
				{
					$( this ).dialog( "destroy" ).remove();
				},
				closeOnEscape: true,
				draggable: false,
				title: 'Add ' + tableName,
				width: 300,
				resizable: false,
				modal: true,
				buttons: 
				{
					'Save': function() 
					{
						var serialData = $('form', this).serializeArray();
						var selectedArr = new Array();
						for (var i=0;i<serialData.length;i++)
						{ 
							selectedArr.push(serialData[i].name);
						}	
						$('#' + writeTargetHiddenID ).val(selectedArr.toString());	
						hiddenForPrint(tableName);		
						$( this ).dialog( "close" );
					}
				}
			});
		},
		error: function()
		{
			alert('error add ' + tableName);	
		}
	});
}
