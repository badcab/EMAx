function eventAddGrade()
{
	unifiedEventAdd('Grade', 'gradeEventMapHiddenText');	
	gradeHiddenForPrint($('#gradeEventMapHiddenText').val());
}
function eventAddOption()
{
	unifiedEventAdd('Option', 'optionEventMapHiddenText');
	optionHiddenForPrint($('#optionEventMapHiddenText').val());
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
