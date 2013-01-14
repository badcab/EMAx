function loadContent(locationOfhtml, idVal, optionVal)
{
	idVal = typeof idVal !== 'undefined' ? idVal : 'none';
	optionVal = typeof optionVal !== 'undefined' ? optionVal : 'none' ;
	$.ajax
	({
		type: 'POST',
		url: locationOfhtml ,
		data: {id: idVal, option: optionVal},
		dataType: "html",
		success:	function(result)
		{
			$("#content").html(result);
			$("#search").val(null);
				/* may need to add this to the tail of the load content script */
			$('#editButton').remove();
			$(":input").removeProp("disabled");
		},
		error: function()
		{
			$("#tooltip").html("error load content");
		}
	});
}
