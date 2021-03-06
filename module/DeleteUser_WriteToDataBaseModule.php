<?php
if(!isset($_SESSION))
{		
	session_start();
}
require_once('../model/LoginModel.php');
require_once('../configure/EMAxSTATIC.php');
class DeleteUser_WriteToDataBaseModule
{
	public function activate($userName, $authorizeUser)
	{
		$CurrentUser = new LoginModel($authorizeUser);	
		if($CurrentUser->getauthorityLevel() == EMAxSTATIC::$AUTH_LEVEL_ADMIN)
		{
			$AffectedUser = new LoginModel($userName);
			$AffectedUser->deleteRecord();
		}
	}
}
?>