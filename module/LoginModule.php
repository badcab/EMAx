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
			if($this->verifyPassword())
			{					
				return $this->fullLoginObject->getuserName();	
			}	
		}
		return FALSE;
	}	
	
	private function verifyUserExists()
	{
		$userList = $this->emptyLoginObject->getList();
		$userArr = array();
		foreach($userList as $user) $userArr[] = $user['name'];
		if(in_array($this->user, $userArr))
		{
			require_once('../model/LoginModel.php');
			$this->fullLoginObject = new LoginModel($this->user);
			return TRUE;	
		}
		return FALSE;
	}
	
	private function verifyPassword()
	{		
		return $this->fullLoginObject->checkPassword($this->password);//return bool
	}
}
?>