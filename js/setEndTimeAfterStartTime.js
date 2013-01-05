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