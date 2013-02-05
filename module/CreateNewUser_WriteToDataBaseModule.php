<?php
require_once('../configure/EMAxSTATIC.php');
require_once('../model/LoginModel.php');
class CreateNewUser_WriteToDataBaseModule
{
	function __construct()
	{
	}
	public function activate($userName, $password, $authorizeUser = $_SESSION['user'])
	{
		$Login = new LoginModel();
		//check if name already exists
		if(in_array(ucwords(strtolower($userName)), $Login->getList()))
		{
			/*do nothing*/
			error_log("User Name already Exists");
		}
		else
		{
			$CurrentUser = new LoginModel($authorizeUser);
			if($CurrentUser->getauthorityLevel() == EMAxSTATIC::$AUTH_LEVEL_ADMIN)
			{
				$Login->setuserName($userName);
				$Login->setpassword($password);
				$Login->writeData();
			}
		}
	}
}
?>
