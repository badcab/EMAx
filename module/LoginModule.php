<?php 
require_once('../configure/EMAxSTATIC.php');
class LoginModule
{
	private $user;
	private $password;
	private $emptyLoginObject;
	private $fullLoginObject;

	function __construct($user, $password)
	{
		$this->user = ucwords(strtolower($user));
		$this->password = $password;
		require_once('../model/LoginModel.php');
		$this->emptyLoginObject = new LoginModel();
	}
	
	public function activate()
	{

		if($this->verifyUserExists())
		{
error_log("user exists");
			if($this->verifyPassword())
			{
error_log("passwords match");
				$this->log_user_login();
				return $this->fullLoginObject->getuserName();	
			}	
		}
		return FALSE;
	}	
	
	private function verifyUserExists()
	{
		$userList = $this->emptyLoginObject->getList();
		if(in_array($this->user, $userList))
		{
			require_once('../model/LoginModel.php');
			$this->fullLoginObject = new LoginModel($this->user);
			return TRUE;	
		}
		return FALSE;
	}
	
	private function log_user_login()
	{
		date_default_timezone_set(EMAxSTATIC::$TIMEZONE);
		$loginLog = "User: " . $this->user . " has logged in " . date('Y-m-d H:i:s');

error_log($loginLog);
	}
	
	private function verifyPassword()
	{
		return $this->fullLoginObject->checkPassword($this->password);//return bool
	}
}
?>