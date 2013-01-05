function eventAddOption()
{
	$.ajax
	({
		type: 'POST',
		url: 'RPC/OptionTableRPC.php' ,
		dataType: "html",
		success:	function(result)
		{
			$(result).dialog({										
				open: function()
				{
					var alreadyChecked = $("#optionEventMapHiddenText").val();
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
				title: 'Add Options',
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
						$("#optionEventMapHiddenText").val(selectedArr.toString());	
						$( this ).dialog( "close" );
					}
				}
			});
		},
		error: function()
		{
			alert("error add option");	
		}
	});
}