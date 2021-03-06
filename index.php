<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<?php
	set_include_path(dirname(__FILE__));
	require_once('configure/EMAxSTATIC.php');
	global $CONFIG;
	if(!isset($_SESSION))
	{		
		if($CONFIG->USE_SSL)
		{
			if(empty($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] !== "on")
			{ 
				header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]); 
				exit();
			}
		}
		session_start();
		date_default_timezone_set($CONFIG->TIMEZONE); 
		$_SESSION['user'] = '';//I don't think this is needed, remove later
	}
	
?>
	<title>EMAx Event Management Application eXtended</title>	
	<link type="text/css" href="css/EMAx.css" rel="stylesheet" />
	<link rel="stylesheet" href="css/Print_EMAx.css" type="text/css" media="print" />
	<!-- 
		<link rel="stylesheet" href="css/Mobile_EMAx.css" type="text/css" media="handheld" />
	-->

	<script src="<?= $CONFIG->PATH_JQUERY ?>"></script>
	<script src="<?= $CONFIG->PATH_JQUERY_UI ?>"></script>
	<script type="text/javascript" src="js/EMAx.js"></script>
	<link type="text/css" href="<?= $CONFIG->PATH_JQUERY_UI_CSS ?>" rel="stylesheet" />
	
</head>
<body>
	<div id="header" class="noPrint">
		<div id="searchBar">
			<input type="text" name="search" id="search" class="isLogin" onclick="Etera.autoCompleteSearch()"/>
			<input type="button" value="Search" class="isLogin" onclick="LoadContent.loadContent('RPC/SearchResultsRPC.php', $('#search').val())"/>
			<input type="checkbox" id="searchByDate" class="isLogin" onchange="Etera.SearchByDate(this)" > 
				<span class="isLogin"  class="noPrint"> Search By Date </span> 
			</input>
			<script type="text/javascript" > Etera.SearchByDate($('#searchByDate')) </script>
		</div>
		<div id="userStatus" class="isLogin"></div>
	</div>
	<div id="mainArea">
		<div id="sidebar" class="noPrint">
			<ul id="mainList">
				<li>
					<input type="button" class="isLogin" value="Event" onclick="LoadContent.loadContent('RPC/EventRPC.php')" />
				</li>
				<li>
					<input type="button" class="isLogin" value="Organization" onclick="LoadContent.loadContent('RPC/OrganizationRPC.php')" />
				</li>
				<li>
					<input type="button" class="isLogin" value="Person" onclick="LoadContent.loadContent('RPC/PersonRPC.php')" />
				</li>
				<li>
					<input type="button" class="isLogin" value="Reports" onclick="LoadContent.loadContent('RPC/ReportRPC.php')" />
				</li>
				<li>
					<input type="button" class="isLogin" value="Logout" onclick="LoadContent.loadContent('RPC/LogoutRPC.php')" />
				</li>
			
				<li>
					<input type="button" class="isLogin Admin" value="Miscellaneous" onclick="LoadContent.loadContent('RPC/MiscellaneousRPC.php')" />
				</li>			
				<li>
					<input type="button" class="isLogin Admin" value="Create User" onclick="Login.createNewUser()" />				
				</li>
				<li>
					<input type="button" class="isLogin Admin" value="Delete User" onclick="Login.deleteUser()" />			
				</li>
				<li>
					<input type="button" class="isLogin Admin" value="Change User Password" onclick="Login.setUserPassword()" />				
				</li>
			</ul>
		</div>
		<div id="content">
			<script type="text/javascript" >LoadContent.loadContent('RPC/LoginRPC.php');</script>
		</div>
	</div>
	<div id="footer" class="noPrint">
		<div id="tooltip" class="isLogin"></div>	
	</div>
	<div class="modal"></div>
</body>
</html>