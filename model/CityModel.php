<?php

class CityModel
{
	private $ClassObjectArg;
	private $cityList;
	
	function __construct($id = NULL)//is_ numeric
	{
		require('../configure/db_connect.php');
		$connection = new PDO('mysql:host='. $db_host .';dbname=' . $db_name, $db_user, $db_password);
		$id = ($id == '') ? NULL : $id;
		
		if(is_string($id))
		{
			if(is_null($id)) {return $id;}
			$name = (ucwords(strtolower($id)));
			$exists = $connection->query("SELECT * FROM `EMAx_City` WHERE name='" . $name . "')");
			$existsReturn = ($exists) ? $exists->fetch(PDO::FETCH_OBJ) : NULL;
			if($existsReturn)
			{
				$id = (int)$existsReturn->ID;
			}
			
			if($id && is_int($id))
			{
				/*Do Nothing*/
			}
			
			else
			{
				$connection->exec("INSERT INTO `EMAx_City`(`name`) VALUES ('" . $name . "')");
				$exists = $connection->query("SELECT * FROM `EMAx_City` WHERE name='" . $name . "'");
				$create = $exists->fetch(PDO::FETCH_OBJ);
				$id = (int)$create->ID;
			}	
		}
		
		$currentDBvalues = NULL;
		
		if($id && is_int($id))
		{
			$result = $connection->query("SELECT * FROM `EMAx_City` WHERE ID=" . $id);
			$currentDBvalues = $result->fetch(PDO::FETCH_OBJ);
		}
		
		$cityList = $connection->query("SELECT * FROM `EMAx_City`");
		$this->cityList = $cityList->fetchAll(); 
		
		$connection = NULL;
		
		if($currentDBvalues)
		{
			$name = $currentDBvalues->name;
		}
		
		else
		{
			$id = NULL;
			$name = NULL;
		}
		
		$this->ClassObjectArg = array(
			'ID' => $id,
			'name' => $name		
		);
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
		$connection->exec("DELETE FROM `EMAx_City` WHERE `ID`='" . getID() . "'");
	}
	
	public function getCity()
	{
		return $this->ClassObjectArg['name'];	
	}
	
	public function setCity($value)
	{
		$value = ($value == '') ? NULL : $value;
		$this->ClassObjectArg['name'] = (ucwords(strtolower($value)));
	}
	
	public function getList()
	{
		$listArr = array();
		foreach($this->cityList as $list)	
		{
//			$listArr[$list['ID']] = $list['name'];
			$listArr[] = array( 'id' => $list['ID'], 'name' => $list['name']);
		}
		return $listArr;
	}
}
 
?>