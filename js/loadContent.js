function loadContent(locationOfhtml, idVal, optionVal, isolation)
{
	$('#content form').remove();  //not sure if this is necessary at this juncture but we shall find out.
	
	idVal = typeof idVal !== 'undefined' ? idVal : 'none';
	optionVal = typeof optionVal !== 'undefined' ? optionVal : 'none' ;
	optionVal = typeof isolation !== 'undefined' ? isolation : null ;
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
			if(isolation) isolation();
		},
		error: function()
		{
			$("#tooltip").html("error load content");
		}
	});
}
function loadIsolatedContent(id, tableName)
{
	var RPClocation = 'RPC/' + tableName + 'RPC.php';
	loadContent(RPClocation, id, null, function(){editPage($('form', '#content'));});
}
function editPage(form)
{
	$(":input", form).prop("disabled", true);
	$("td:last", form).html('<input type="button" value="Edit" id="editButton" onclick="editButtonClick(this.form, this)" />');
}
function editButtonClick(form, eButton)
{
	$("td:last", form).html("");
//	$(":input", form).prop("disabled", false);
	$(":input", form).removeProp("disabled");
	$(eButton).remove();
}
/* we will need to objectify this */
/* we will need to objectify this */