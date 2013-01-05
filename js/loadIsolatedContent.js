function loadIsolatedContent(id, tableName)
{
	var RPClocation = 'RPC/' + tableName + 'RPC.php';
	loadContent(RPClocation, id);

	var tableTDbutton;

	$(this.form).children().each(
	    function(){
	        tableTDbutton = $('[type="button"]').closest('td');
	        $(tableTDbutton).html('');
	    }
	);

	$(this.form).children().each(
	    function(){
	        $(this).closest('td').html( $(this).val() );
	    }
	);

	$(tableTDbutton).html('<input type="button" value="Edit" onclick="loadContent(' 
		+ RPClocation + ', ' + 
		+ id + ', ' +
		+ tableName +
	')"/>');
}