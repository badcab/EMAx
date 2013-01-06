<?php 
require_once('../model/_SearchModel.php');
class DefaultViewController
{
	function __construct()
	{
		if(!isset($_SESSION)) 
		{ 
			session_start();
		} 
	}
	
	public function activate($id = NULL)
	{
		if(!$_SESSION['isLoggedIn'])
		{
			require_once('../view/LoginView.php');
			return;
		}

		$DefaultView = new _SearchModel();
		$upcomingEvents = $DefaultView->getDefaultView();
		require_once('../view/DefaultViewView.php');
	}
}
?>