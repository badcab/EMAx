<?php
if(!isset($_SESSION))
{		
	session_start();
}
require_once('../configure/EMAxSTATIC.php');
require_once('../model/LoginModel.php');
class CreateNewUser_WriteToDataBaseModule
{
	function __construct()
	{
	}
	public function activate($userName, $password, $authorizeUser)
	{
error_log("line 15 CreateNewUser_WriteToDataBaaseModule inside activate");		
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
error_log($authorizeUser . " authouris user");
			if($CurrentUser->getauthorityLevel() == EMAxSTATIC::$AUTH_LEVEL_ADMIN)
			{
error_log("line 28 Create new user module inside athourity block");
				$Login->setuserName($userName);
				$Login->setpassword($password);
				$Login->writeData();
			}
		}
		unset($Login);
	}
}
?>
