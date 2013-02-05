<?php
require_once('../model/LoginModel.php');
require_once('../configure/EMAxSTATIC.php');
class ChangeUserPassword_WriteToDataBaseModule
{
	public function activate($userName, $newPassword, $authorizeUser = $_SESSION['user'])
	{
		$CurrentUser = new LoginModel($authorizeUser);	
		if($CurrentUser->getauthorityLevel() == EMAxSTATIC::$AUTH_LEVEL_ADMIN)
		{
			$AffectedUser = new LoginModel($userName);
			$AffectedUser->setpassword($newPassword);
			$AffectedUser->writeData();
		}
	}
}
?>