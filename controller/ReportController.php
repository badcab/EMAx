<?php 
//require_once('../model/ReportModel.php');
class ReportController
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
//		$Report = new ReportModel($id);
		require_once('../view/ReportView.php');
	}
}
?>