function emailValid(field)
{
	var email = field.value;

    if(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)) 
    {
    	field.value = email;	
		$("#tooltip").html("email correctly formed (or close enough)");
    }
    else
    {
    	field.value = '';	
		$("#tooltip").html("email Address malformed, try again");	
    }
}

function phoneValid(field)
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