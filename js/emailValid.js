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