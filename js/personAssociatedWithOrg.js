function personAssociatedWithOrg(organization)
{
	$.ajax
	({
  		type: "POST",
  		url: "RPC/PeopleInOrganizationRPC.php",
 		data: { orgID: organization.value },
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