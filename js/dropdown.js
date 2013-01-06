function personAssociatedWithOrg(organization)
{
	var orgValue = organization.value;
	//so we need to allow int to be passed in
	$.ajax
	({
  		type: "POST",
  		url: "RPC/PeopleInOrganizationRPC.php",
 		data: { orgID: orgValue },
 		dataType: "html",
		success:	function(result)
		{
			$("#PersonEventDropDown").remove();
			$("#person").html(result);
		},
		error: function()
		{
			$("#tooltip").html("something went wrong in person associated with org");		
		}
	});
}

function setDropDownValue(dropDownObj, valueToSet)
{
	$(dropDownObj).val(valueToSet);
}

function setEndTimeAfterStartTime(endTime)
{
//	var startTime = document.getElementById("startTime");

//	if(startTime.value > endTime.value)
//	{
//		startTime.value = endTime.value;
//	}

	if($('#startTime').val() > $(endTime).val())
	{
		$('#startTime').val($(endTime).val());
	}		
	
}

function setPersonDropDown(orgDropDown)
{
		//make an ajax call for a list of people who work for the value (id) of the org and set it
		
		//we will need an RPC call here
}

function setPersonInForm(dropdown)
{
//	alert(dropdown.value);
	$('#PersonEvent').val($(dropdown).val());
}

function setTimePlus2Hr(feild)
{
	var endTime = document.getElementById("endTime");
	var startTimePlus = parseInt(feild.value) + (900 * 8);
	var maxTime = 1352997900;
	
//	if(startTimePlus > maxTime)
//	{
//		endTime.value = maxTime;
//		return;
//	}
	
	endTime.value = startTimePlus;	
}