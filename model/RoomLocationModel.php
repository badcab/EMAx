<?php

class RoomLocationModel
{
	private $ClassObjectArg;
	private $RoomLocationList;
	
	function __construct($id = NULL, $cost = 0.00)
	{
		require('../configure/db_connect.php'); 
		$connection = new PDO('mysql:host='. $db_host .';dbname=' . $db_name, $db_user, $db_password);
		$currentDBvalues = NULL;
		$roomLocationList = $connection->query("SELECT `ID`,`name`,`cost` FROM `EMAx_RoomLocation`");
		$this->RoomLocationList = $roomLocationList->fetchAll();			
		
		if(is_string($id))
		{
			$name = (ucwords(strtolower($id)));
			$exists = $connection->query("SELECT * FROM `EMAx_RoomLocation` WHERE name='" . $name . "'");
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
				$create = $connection->exec("INSERT INTO `EMAx_RoomLocation`(`name`, `cost`) VALUES ('" . $name . "','" . $cost . "')");
				$exists = $connection->query("SELECT * FROM `EMAx_RoomLocation` WHERE name='" . $name . "'");
				$createReturn = $exists->fetch(PDO::FETCH_OBJ);
				$id = (int)$createReturn->ID;
			}	
		}
	
		if($id && is_int($id))
		{
			$result = $connection->query("SELECT * FROM `EMAx_RoomLocation` WHERE ID=" . $id);
			$currentDBvalues = $result->fetch(PDO::FETCH_OBJ);
		}
		
		$connection = NULL;
		
		if($currentDBvalues)
		{
			$name = $currentDBvalues->name;
			$notes = $currentDBvalues->notes;
			$cost = $currentDBvalues->cost;
		}
		
		else
		{
			$id = NULL;
			$name = NULL;
			$notes = NULL;
//			$cost = NULL;
		}
		
		$this->ClassObjectArg = array(
			'ID' => $id,
			'name' => $name,
			'notes' => $notes,	
			'cost' => $cost	
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
			UPDATE `EMAx_Event` 
			SET `EMAx_Event`.`EMAx_RoomLocation_ID`= NULL 
			WHERE `EMAx_Event`.`EMAx_RoomLocation_ID`= '" .$id . "'"
		);
		$connection->exec("DELETE FROM `EMAx_RoomLocation` WHERE `ID`='" . $id . "'");
	}	
	
	public function getRoomLocation()
	{
		return $this->ClassObjectArg['name'];
	}
	
	public function getnotes()
	{
		return $this->ClassObjectArg['notes'];
	}
	
	public function getCost()
	{
		return $this->ClassObjectArg['cost'];	
	}
	
	public function setCost($value)
	{
		if(is_numeric($value))
		{
			$this->ClassObjectArg['cost'] = (double)$value;
		}
	}		
	
	public function setRoomLocation($value)
	{
		$value = ($value == '') ? NULL : $value;
		$this->ClassObjectArg['name'] = (ucwords(strtolower($value)));
	}
	
	public function setnotes($value)
	{
		$value = ($value == '') ? NULL : $value;
		$this->ClassObjectArg['notes'] = ($value);
	}
	
	public function getList()
	{
		$listArr = array();
		foreach($this->RoomLocationList as $list)	
		{
			$listArr[] = array( 'id' => $list['ID'], 'name' => $list['name'], 'cost' => $list['cost']);
		}
		return $listArr;
	}
}
 
?>
