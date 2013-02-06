<?php
require_once('../configure/EMAxSTATIC.php');
class LoginModel
{
	private $ClassObjectArg;
	private $LoginList;
	function __construct($id = NULL)
	{
		$currentDBvalues = NULL;
		$connection = new PDO('mysql:host='. EMAxSTATIC::$db_host .';dbname=' . EMAxSTATIC::$db_name, EMAxSTATIC::$db_user, EMAxSTATIC::$db_password);
		$loginList = $connection->query("SELECT `ID`,`userName` FROM `EMAx_Login`");
		$this->LoginList = $loginList->fetchAll();
		$id = ($id == '') ? NULL : $id;
		if(is_string($id))
		{
			$name = ucwords(strtolower($id));
			$sql = "SELECT * FROM `EMAx_Login` WHERE userName=" . $connection->quote($name);
			$exists = $connection->query($sql);
			$existsReturn = $exists->fetch(PDO::FETCH_OBJ);
			if($existsReturn)
			{
				$id = (int)$existsReturn->ID;
			}
		}
		if($id && is_int($id))
		{
			$result = $connection->query("SELECT * FROM `EMAx_Login` WHERE ID=" . $connection->quote($id));
			$currentDBvalues = $result->fetch(PDO::FETCH_OBJ);
		}
		$connection = NULL;
		if($currentDBvalues)
		{
			$userName = $currentDBvalues->userName;
			$password = $currentDBvalues->password;
			$authorityLevel = $currentDBvalues->authorityLevel;
		}
		else
		{
			$id = NULL;
			$userName = NULL;
			$password = NULL;
			$authorityLevel = NULL;
		}
		$this->ClassObjectArg = array(
			'ID' => $id,
			'userName' => $userName,
			'password' => $password,
			'authorityLevel' => $authorityLevel
		);
	}
	public function writeData()
	{
		/*At this point in time writing the authorityLevel is not allowed*/
		$connection = new PDO('mysql:host='. EMAxSTATIC::$db_host .';dbname=' . EMAxSTATIC::$db_name, EMAxSTATIC::$db_user, EMAxSTATIC::$db_password);
		if($this->ClassObjectArg['ID'])
		{
			$sql = "
				UPDATE `EMAx_Login` SET " .
				"`userName`=". $connection->quote($this->ClassObjectArg['userName'])
				.",`password`=". $connection->quote($this->ClassObjectArg['password'])
				." WHERE `ID`=" . $connection->quote($this->ClassObjectArg['ID']) ;
		}
		else
		{
			$sql =
				"INSERT INTO `EMAx_Login`(
					`userName`,
					`password`
				) VALUES (
					". $connection->quote($this->ClassObjectArg['userName']) .",
					". $connection->quote($this->ClassObjectArg['password']) ."
				)";
		}
error_log($sql);		
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
		$connection = new PDO('mysql:host='. EMAxSTATIC::$db_host .';dbname=' . EMAxSTATIC::$db_name, EMAxSTATIC::$db_user, EMAxSTATIC::$db_password);
		/*handle dependancies*/
		$connection->exec("DELETE FROM `EMAx_Login` WHERE `ID`=" . $connection->quote($this->getID()) );
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
		if($passwordPlain == $this->getpassword() && $passwordPlain == 'Admin')
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
		$hashedPassword = sha1($plainTextPassword . EMAxSTATIC::$passwordSalt . $this->getuserName());
		return $hashedPassword;
	}

	public function getauthorityLevel()
	{
		return $this->ClassObjectArg['authorityLevel'];
	}	
	
	public function setauthorityLevel($value)
	{
		$this->ClassObjectArg['authorityLevel'] = (int)$value;
	}
	
	public function getList()
	{
		$listArr = array();
		foreach($this->LoginList as $list)
		{
			$listArr[] = array( 'id' => $list['ID'], 'name' => $list['userName']);
		}
		return $listArr;
	}
}
?>
