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