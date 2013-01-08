function loadIsolatedContent(id, tableName)
{	
	var RPClocation = 'RPC/' + tableName + 'RPC.php';
	loadContent(RPClocation, id);
//this works but it is very sloppy, should fix later time premiting.
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
	$("td:last", form).html('<input type="button" value="Edit" onclick="editButtonClick(form)" />');
}

function editButtonClick(form)
{
	$("td:last", form).html("");
	$(":input", form).prop("disabled", false);	
}

		