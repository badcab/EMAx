<?php  
	if(!isset($_SESSION))
	{
		session_start();
	}

	session_destroy();
	
	echo('<script> $(".isLogin").hide(); document.location.href = "/EMAx"; </script>')
?>
