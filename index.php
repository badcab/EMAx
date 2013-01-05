<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<?php
	set_include_path(dirname(__FILE__));
	require_once('configure/EMAxSTATIC.php');

	if(!isset($_SESSION))
	{		
		if($_SERVER["HTTPS"] != "on" && EMAxSTATIC::$USE_SSL)
		{
			header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
	   	exit();
		}

		session_start();
		date_default_timezone_set(EMAxSTATIC::$TIMEZONE); 
		$_SESSION['user'] = '';
	}
?>
	<title>EMAx Event Management Application eXtended</title>	
	<link type="text/css" href="css/EMAx.css" rel="stylesheet" />
	
<!--
	<script type="text/javascript" src="../jQuery/jquery.min.js"></script>
	<script type="text/javascript" src="../jQuery/jquery-ui.min.js"></script>
	<link type="text/css" href="../jquery-ui.css" rel="stylesheet" />
-->

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
	<link type="text/css" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.0/themes/base/jquery-ui.css" rel="stylesheet" />
	
	<script type="text/javascript" src="js/valid.js"></script>
	<script type="text/javascript" src="js/eventAdd.js"></script> 
	<script type="text/javascript" src="js/quickie.js"></script> 
	<script type="text/javascript" src="js/dropdown.js"></script> 
	
	<script type="text/javascript" src="js/loadContent.js"></script>	
	<script type="text/javascript" src="js/clearFormData.js"></script> 
	<script type="text/javascript" src="js/collectFormDataAjax.js"></script> 
	<script type="text/javascript" src="js/loginScript.js"></script> 
	<script type="text/javascript" src="js/createNewUser.js"></script>
	<script type="text/javascript" src="js/checkBoxFix.js"></script>
	<script type="text/javascript" src="js/miscellaneousScript.js"></script>
	<script type="text/javascript" src="js/SearchByDate.js"></script>
	<script type="text/javascript" src="js/changePassword.js"></script>
	<script type="text/javascript" src="js/loadIsolatedContent.js"></script>

</head>
<body>
	<div id="header">
		<div id="searchBar">
			<input type="text" name="search" id="search" class="isLogin" onclick=""/>
			<input type="button" value="Search" class="isLogin" onclick="loadContent('RPC/SearchResultsRPC.php', $('#search').val())"/>
			<input type="checkbox" id="searchByDate" class="isLogin" onchange="SearchByDate(this)" > 
				<span class="isLogin"> Search By Date </span> 
			</input>
			<script type="text/javascript" > SearchByDate($('#searchByDate')) </script>
		</div>
		<div id="userStatus" class="isLogin"></div>
	</div>
	<div id="mainArea">
		<div id="sidebar">
			<ul id="mainList">
				<li>
					<input type="button" class="isLogin" value="Event" onclick="loadContent('RPC/EventRPC.php')" />
				</li>
				<li>
					<input type="button" class="isLogin" value="Organization" onclick="loadContent('RPC/OrganizationRPC.php')" />
				</li>
				<li>
					<input type="button" class="isLogin" value="Person" onclick="loadContent('RPC/PersonRPC.php')" />
				</li>
				<li>
					<input type="button" class="isLogin" value="Reports" onclick="loadContent('RPC/ReportRPC.php')" />
				</li>
				<li>
					<input type="button" class="isLogin" value="Miscellaneous" onclick="loadContent('RPC/MiscellaneousRPC.php')" />
				</li>
				<li>
					<input type="button" class="isLogin" value="Logout" onclick="loadContent('RPC/LogoutRPC.php')" />
				</li>
				<li>
					<input type="button" class="isLogin" value="createUser" onclick="createNewUser()" />				
				</li>
			</ul>
		</div>
		<div id="content">
			<script type="text/javascript" >loadContent('RPC/LoginRPC.php');</script>
		</div>
	</div>
	<div id="footer">
		<div id="tooltip" class="isLogin"></div>	
	</div>
	<div class="modal"></div>
</body>
</html>