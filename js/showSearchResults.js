function showSearchResults(var searchString)
{
	var searchArr = searchString.split(" ");
	
	$.ajax
	({
  		type: "POST",
  		url: "RPC/SearchResultsRPC.php",
 		data: { searchArr } 
	}).done(function( html ) 
	{
  		$("#content").html(html);
	});
}