function checkBoxFix(field, idOfHiddenInput)
{
//	alert("checkbox changed");

	if(field.checked)
	{	
		$('#' + idOfHiddenInput).val(1);
	}	
	
	else
	{
		$('#' + idOfHiddenInput).val(0);
	}
	
}