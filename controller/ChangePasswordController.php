<?php
class ChangePasswordController
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
		require_once('../view/ChangePasswordView.php');
	}
}
?>