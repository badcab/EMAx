<?php

class StateModel
{
	private $ClassObjectArg;
	private $stateList;
	
	function __construct($id = NULL)
	{
		$currentDBvalues = NULL;
		require('../configure/db_connect.php');
		$connection = new PDO('mysql:host='. $db_host .';dbname=' . $db_name, $db_user, $db_password);
		$id = ($id == '') ? NULL : $id;
		if(is_string($id))
		{
			if(is_null($id)) {return $id;}
			$name = (ucwords(strtolower($id)));
			$exists = $connection->query("SELECT * FROM `EMAx_State` WHERE name='" . $name . "'");
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
				$create = $connection->exec("INSERT INTO `EMAx_State`(`name`) VALUES ('" . $name . "')");
				$exists = $connection->query("SELECT * FROM `EMAx_State` WHERE name='" . $name . "'");
				$createReturn = $exists->fetch(PDO::FETCH_OBJ);
				$id = (int)$createReturn->ID;
			}	
		}
	
		if($id && is_int($id))
		{
			$result = $connection->query("SELECT * FROM `EMAx_State` WHERE ID=" . $id);
			$currentDBvalues = $result->fetch(PDO::FETCH_OBJ);
		}
		
		$stateList = $connection->query("SELECT * FROM `EMAx_State`");
		$this->stateList = $stateList->fetchAll();
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
		$id = $this->getID();

		$connection->exec("
			UPDATE `EMAx_Person` 
			SET `EMAx_Person`.`EMAx_State_ID`= NULL 
			WHERE `EMAx_Person`.`EMAx_State_ID`= '" .$id . "'"
		);
		$connection->exec("
			UPDATE `EMAx_Organization` 
			SET `EMAx_Organization`.`EMAx_State_ID`= NULL 
			WHERE `EMAx_Organization`.`EMAx_State_ID`= '" .$id . "'"
		);

		$connection->exec("DELETE FROM `EMAx_State` WHERE `ID`='" . $id . "'");
	}	
	
	public function getState()
	{
		return $this->ClassObjectArg['name'];
	}
	
	public function setState($value)
	{
		$value = ($value == '') ? NULL : $value;
		$this->ClassObjectArg['name'] = (ucwords(strtolower($value)));
	}
	
	public function getList()
	{
		$listArr = array();
		foreach($this->stateList as $list)	
		{
			$listArr[] = array( 'id' => $list['ID'], 'name' => $list['name']);
		}
		return $listArr;
	}
}
 
?>