<?php
$user = (isset($_POST['user'])) ? $_POST['user'] : NULL;
$password = (isset($_POST['password'])) ? $_POST['password'] : NULL;

	if(!isset($_SESSION))
	{
		session_start();
	}
	require_once('../module/LoginModule.php');
	$Login = new LoginModule($user, $password);
	$isValidLogin = $Login->activate();
	if($isValidLogin)
	{
		$_SESSION['user'] = $isValidLogin;
		$_SESSION['isLoggedIn'] = TRUE;
		echo($isValidLogin);
	}
	else
	{
		echo('FALSE');
	}
?>
