function personAssociatedWithOrg(organization)
{
	var orgValue;

	if(typeof(organization)=='string')
	{	
		orgValue = organization;
	}
	else
	{
		orgValue = organization.value;
	}

	$.ajax
	({
  		type: "POST",
  		url: "RPC/PeopleInOrganizationRPC.php",
 		data: { orgID: orgValue },
 		dataType: "html",
		success:	function(result)
		{
			$('select[name="dropDownPerson"]', this.form).remove();
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
	var startTime = $('select[name="startTime"]', this.form);

	if(startTime.value > endTime.value)
	{
		startTime.value = endTime.value;
	}

	if($('select[name="startTime"]', this.form).val() > $(endTime).val())
	{
		$('select[name="startTime"]', this.form).val($(endTime).val());
	}		
	
}

function setPersonInForm(dropdown)
{
	$('select[name="Person"]', this.form).val($(dropdown).val());
}

function setTimePlus2Hr(feild)
{
	var endTime = $('select[name="endTime"]', this.form);
	var startTimePlus = parseInt(feild.value) + (900 * 8);
	var maxTime = 1352997900;
	
	if(startTimePlus > maxTime)
	{
		endTime.value = maxTime;
		return;
	}	
	endTime.value = startTimePlus;	
}