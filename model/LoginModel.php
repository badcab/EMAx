<?php

class LoginModel
{
	private $ClassObjectArg;
	private $LoginList;
	
	function __construct($id = NULL)
	{
		require('../configure/db_connect.php'); 
		$currentDBvalues = NULL;
		$connection = new PDO('mysql:host='. $db_host .';dbname=' . $db_name, $db_user, $db_password);
		$loginList = $connection->query("SELECT `ID`,`userName` FROM `EMAx_Login`");
		$this->LoginList = $loginList->fetchAll();	
		$id = ($id == '') ? NULL : $id;
		if(is_string($id))
		{
			$name = ucwords(strtolower($id));
			$exists = $connection->query("SELECT * FROM `EMAx_Login` WHERE userName='" . $name . "'");	
			$existsReturn = $exists->fetch(PDO::FETCH_OBJ);
			if($existsReturn)
			{
				$id = (int)$existsReturn->ID;
			}
		}
		if($id && is_int($id))
		{
			$result = $connection->query("SELECT * FROM `EMAx_Login` WHERE ID=" . $id);
			$currentDBvalues = $result->fetch(PDO::FETCH_OBJ);
		}

		$connection = NULL;
		
		if($currentDBvalues)
		{
			$userName = $currentDBvalues->userName;
			$password = $currentDBvalues->password;
		}
		
		else
		{
			$id = NULL;
			$userName = NULL;
			$password = NULL;
		}
		
		$this->ClassObjectArg = array(
			'ID' => $id,		
			'userName' => $userName,
			'password' => $password
		);
	}

	public function writeData()
	{
		require('../configure/db_connect.php');
		$connection = new PDO('mysql:host='. $db_host .';dbname=' . $db_name, $db_user, $db_password);
		
		if($this->ClassObjectArg['ID'])
		{
			$sql = "
				UPDATE `EMAx_Login` SET " .
				"`userName`='". $this->ClassObjectArg['userName']  
				."',`password`='". $this->ClassObjectArg['password']  
				."' WHERE `ID`='" . $this->ClassObjectArg['ID'] . "'";			
		}
		
		else
		{
			$sql = 
				"INSERT INTO `EMAx_Login`(
					`userName`, 
					`password`
				) VALUES (
					'". $this->ClassObjectArg['userName'] ."',
					'". $this->ClassObjectArg['password'] ."'
				)";
		}			
	
		$success = $connection->exec($sql);	
		$connection = NULL;	
		return $success;
	}

	public function getID()
	{
		return (int)$this->ClassObjectArg['ID'];
	}
	
	public function deleteRecord()
	{
		require('../configure/db_connect.php');
		$connection = new PDO('mysql:host='. $db_host .';dbname=' . $db_name, $db_user, $db_password);
		/*handle dependancies*/
		$connection->exec("DELETE FROM `EMAx_Login` WHERE `ID`='" . $this->getID() . "'");
	}	
	
	public function getuserName()
	{
		return $this->ClassObjectArg['userName'];
	}
	
	public function getpassword()
	{
		return $this->ClassObjectArg['password'];
	}
	
	public function checkPassword($passwordPlain)
	{			
		if($passwordPlain == $this->getpassword() && $passwordPlain == 'admin') 
		{
			return TRUE; //should only be used for default login	
		}	
		
		if($this->hashifyPassword($passwordPlain) == $this->getpassword())
		{
			return TRUE;
		}		
		return FALSE;
	}
	
	public function setuserName($value)
	{
		$value = ($value == '') ? NULL : $value;
		$this->ClassObjectArg['userName'] = ucwords(strtolower($value));
	}
	
	public function setpassword($value)
	{
		$value = ($value == '') ? NULL : $value;
		$this->ClassObjectArg['password'] = $this->hashifyPassword($value);
	}
	
	private function hashifyPassword($plainTextPassword)
	{
		require('../configure/login_user_connect.php');
		$hashedPassword = sha1($plainTextPassword . $passwordSalt);
		//$hashedPassword = sha1($plainTextPassword . $passwordSalt . $this->getuserName());
		return $hashedPassword;	
	}
	
	public function getList()
	{
		$listArr = array();
		foreach($this->LoginList as $list)	
		{
			$listArr[$list['ID']] = $list['userName'];
		}
		return $listArr;
	}
}
 
?>