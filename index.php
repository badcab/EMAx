<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<?php
	set_include_path(dirname(__FILE__));
	require_once('configure/EMAxSTATIC.php');
	if(!isset($_SESSION))
	{		
//		if($_SERVER["HTTPS"] != "on" && EMAxSTATIC::$USE_SSL)
//		{
//			header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
//	   	exit();
//		}

		session_start();
		date_default_timezone_set(EMAxSTATIC::$TIMEZONE); 
		$_SESSION['user'] = '';
	}
?>
	<title>EMAx Event Management Application eXtended</title>	
	<link type="text/css" href="css/EMAx.css" rel="stylesheet" />
	<link rel="stylesheet" href="css/Print_EMAx.css" type="text/css" media="print" />
	<!-- 
		<link rel="stylesheet" href="css/Mobile_EMAx.css" type="text/css" media="handheld" />
	-->

	<script src="<?= EMAxSTATIC::$PATH_JQUERY ?>"></script>
	<script src="<?= EMAxSTATIC::$PATH_JQUERY_UI ?>"></script>
	<script type="text/javascript" src="js/EMAx.js"></script>
	<link type="text/css" href="<?= EMAxSTATIC::$PATH_JQUERY_UI_CSS ?>" rel="stylesheet" />
	
	<script type="text/javascript" src="js/valid.js"></script>
	<script type="text/javascript" src="js/eventAdd.js"></script> 
	<script type="text/javascript" src="js/quickie.js"></script> 
	<script type="text/javascript" src="js/dropdown.js"></script> 
	
	<script type="text/javascript" src="js/loadContent.js"></script>	
	<script type="text/javascript" src="js/collectFormDataAjax.js"></script> 
	<script type="text/javascript" src="js/loginScript.js"></script> 
	
</head>
<body>
	<div id="header" class="noPrint">
		<div id="searchBar">
			<input type="text" name="search" id="search" class="isLogin" onclick=""/>
			<input type="button" value="Search" class="isLogin" onclick="loadContent('RPC/SearchResultsRPC.php', $('#search').val())"/>
			<input type="checkbox" id="searchByDate" class="isLogin" onchange="SearchByDate(this)" > 
				<span class="isLogin"  class="noPrint"> Search By Date </span> 
			</input>
			<script type="text/javascript" > SearchByDate($('#searchByDate')) </script>
		</div>
		<div id="userStatus" class="isLogin"></div>
	</div>
	<div id="mainArea">
		<div id="sidebar" class="noPrint">
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
	<div id="footer" class="noPrint">
		<div id="tooltip" class="isLogin"></div>	
	</div>
	<div class="modal"></div>
</body>
</html>