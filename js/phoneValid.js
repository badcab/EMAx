function phoneValid(field)//to to change selector to this and pass this in as peramiter
{
	phonenum = field.value;

	var raw_number = phonenum.replace(/[^0-9]/g, '');
	if(raw_number.length < 7)
	{
		raw_number = '';
		if(phonenum != '')
		$("#tooltip").html("phone number malformed, try again");
	}
	
	if(raw_number.length == 7)
	{
		raw_number = "920" + raw_number;
		$("#tooltip").html("Area code '920' added to number");
	}
	
	if(raw_number.length > 10)
	{
		//idk padd the end with stuff? EX
		$("#tooltip").html("big phone number, assuming there is an extension");
	}
	
	var regex1 = /^1?([2-9]..)([2-9]..)(....)$/;
	if(!regex1.test(raw_number)) 
	{
		field.value =  raw_number;
	} 
	else 
	{
		field.value = raw_number.replace(regex1,'1 ($1) $2 $3');
	}
}