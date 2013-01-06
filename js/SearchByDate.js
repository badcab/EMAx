function SearchByDate(checkBox)
{
	if($(checkBox).prop("checked"))
	{
		$( "#search" ).val('');
		$( "#search" ).datepicker();
		$( "#search" ).autocomplete({ disabled: true });
	}
	
	else
	{
		$( "#search" ).val('');
		$( "#search" ).datepicker( "destroy" );
		autoCompleteSearch();
		$( "#search" ).autocomplete({ disabled: false });
	}
}