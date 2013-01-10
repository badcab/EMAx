function checkBoxFix(field, idOfHiddenInput)
{
	if(field.checked)
	{	
		$('#' + idOfHiddenInput).val(1);
	}	
	else
	{
		$('#' + idOfHiddenInput).val(0);
	}
}