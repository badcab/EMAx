function loadContent(locationOfhtml, idVal, optionVal)
{
	$('#content form').remove();  //not sure if this is necessary at this juncture but we shall find out.
	
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
		},
		error: function()
		{
			$("#tooltip").html("error load content");
		}
	});
}
