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
	var startTime = $('select[name="startTime"]', endTime.form);
	if(parseInt($(startTime).val()) > parseInt($(endTime).val()))
	{
		$(startTime).val($(endTime).val());
	}
}
function setPersonInForm(dropdown)
{
	$('select[name="Person"]', this.form).val($(dropdown).val());
}
function setTimePlus2Hr(feild)
{
	var endTime = parseInt($(feild).val()) + (900 * 8);
	var maxEndTime = parseInt($(":last", feild).val() );
	endTime = (endTime > maxEndTime) ? maxEndTime : endTime ;
	$('select[name="endTime"]', feild.form).val(endTime);
}
