<?php 
require_once('../model/OptionModel.php');
require_once('../model/RoomLocationModel.php');
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
		if(!$_SESSION['isLoggedIn'])//maybe change this to be user name...
		{
			require_once('../view/LoginView.php');
			return;
		}

		$RoomLocation = new RoomLocationModel();
		$Option = new OptionModel();
		
		$OptionList = $Option->getList();
		$RoomList = $RoomLocation->getList();

		require_once('../view/ReportView.php');
	}
}
?>