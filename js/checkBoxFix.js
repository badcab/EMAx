function checkBoxFix(field, idOfHiddenInput)
{
//	alert("checkbox changed");
//	var hiddenInput = document.getElementById(idOfHiddenInput);

	if(field.checked)
	{
//		hiddenInput.value = 1;	
		$('#' + idOfHiddenInput).val(1);
	}	
	
	else
	{
//		hiddenInput.value =  0;
		$('#' + idOfHiddenInput).val(0);
	}
	
}