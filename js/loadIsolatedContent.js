function loadIsolatedContent(id, tableName)
{
	var RPClocation = 'RPC/' + tableName + 'RPC.php';
	loadContent(RPClocation, id);
	$("html").on({
	    ajaxStop: function()
	    {
	        editPage($('form', '#content'));
	    }
	});
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
