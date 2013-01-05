<?php
class CreateNewUser_WriteToDataBaseModule
{
	function __construct() 
	{
		
	}
	
	public function activate($userName, $password)
	{
		require_once('../model/LoginModel.php');
		$Login = new LoginModel();
		//check if name already exists
		if(in_array(ucwords(strtolower($userName)), $Login->getList()))
		{
			/*do nothing*/
			error_log("User Name already Exists");
		}
		
		else
		{
			$Login->setuserName($userName);
			$Login->setpassword($password);
			$Login->writeData();
			unset($Login);
		}
	}
}
?>