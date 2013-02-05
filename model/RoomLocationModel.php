<?php
require_once('../configure/EMAxSTATIC.php');
class RoomLocationModel
{
	private $ClassObjectArg;
	private $RoomLocationList;
	
	function __construct($id = NULL, $cost = 0.00)
	{
		 
		$connection = new PDO('mysql:host='. EMAxSTATIC::$db_host .';dbname=' . EMAxSTATIC::$db_name, EMAxSTATIC::$db_user, EMAxSTATIC::$db_password);
		$currentDBvalues = NULL;
		$roomLocationList = $connection->query("SELECT `ID`,`name`,`cost` FROM `EMAx_RoomLocation`");
		$this->RoomLocationList = $roomLocationList->fetchAll();			
		
		if(is_string($id))
		{
			$name = (ucwords(strtolower($id)));
			$exists = $connection->query("SELECT * FROM `EMAx_RoomLocation` WHERE name=" . $connection->quote($name) );
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
				$create = $connection->exec("INSERT INTO `EMAx_RoomLocation`(`name`, `cost`) VALUES (" . $connection->quote($name) . "," . $connection->quote($cost) . ")");
				$exists = $connection->query("SELECT * FROM `EMAx_RoomLocation` WHERE name=" . $connection->quote($name) );
				$createReturn = $exists->fetch(PDO::FETCH_OBJ);
				$id = (int)$createReturn->ID;
			}	
		}
	
		if($id && is_int($id))
		{
			$result = $connection->query("SELECT * FROM `EMAx_RoomLocation` WHERE ID=" . $connection->quote($id));
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
	
	/*
	public function writeChanges()
	{
		$connection = new PDO('mysql:host='. EMAxSTATIC::$db_host .';dbname=' . EMAxSTATIC::$db_name, EMAxSTATIC::$db_user, EMAxSTATIC::$db_password);
		$name = $connection->quote($this->getRoomLocation());
		$cost = $connection->quote($this->getCost());
		$notes = $connection->quote($this->getnotes()());
		$id = $connection->quote($this->getID());
		
		$sql = "UPDATE `EMAx_Option` SET `name`={$name},`cost`={$cost}, `notes`={$notes} WHERE `ID` = {$id}";
		$connection->exec($sql);
		$connection = NULL;	
	}

	*/
	
	public function deleteRecord()
	{
		
		$connection = new PDO('mysql:host='. EMAxSTATIC::$db_host .';dbname=' . EMAxSTATIC::$db_name, EMAxSTATIC::$db_user, EMAxSTATIC::$db_password);
		$id = $this->getID();
		
		$connection->exec("
			UPDATE `EMAx_Event` 
			SET `EMAx_Event`.`EMAx_RoomLocation_ID`= NULL 
			WHERE `EMAx_Event`.`EMAx_RoomLocation_ID`= " . $connection->quote($id)
		);
		$connection->exec("DELETE FROM `EMAx_RoomLocation` WHERE `ID`=" . $connection->quote($id) );
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
