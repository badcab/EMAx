function zipValid(field)
{
	zip = field.value;

	var raw_number = zip.replace(/[^0-9]/g, '');
	if(raw_number.length == 5)
	{
		field.value = raw_number;
		$("#tooltip").html("Zip code correctly formatted");
		return;
	}
	
	if(raw_number.length > 5)
	{
		field.value = raw_number.slice(0,5);
		$("#tooltip").html("Zip code to long, using first five numbers");
		return;
	}
	
	if(raw_number.length < 5)
	{
		field.value = '';
		$("#tooltip").html("No enough numbers for valid zip code, try again");
		return;
	}
}