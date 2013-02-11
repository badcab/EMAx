<?php
require_once('../configure/EMAxSTATIC.php');
class RoomLocationModel
{
	private $ClassObjectArg;
	private $RoomLocationList;
	
	function __construct($id = NULL, $costBaseNonProfit = 0.00, $costBaseForProfit = 0.00, $costExtraLongNonProfit = 0.00, $costExtraLongForProfit = 0.00)
	{
		 
		$connection = new PDO('mysql:host='. EMAxSTATIC::$db_host .';dbname=' . EMAxSTATIC::$db_name, EMAxSTATIC::$db_user, EMAxSTATIC::$db_password);
		$currentDBvalues = NULL;
		$roomLocationList = $connection->query("SELECT * FROM `EMAx_RoomLocation`");
		$this->RoomLocationList = $roomLocationList->fetchAll();			
		
		$costBaseNonProfit = $connection->quote( (double)$costBaseNonProfit );
		$costBaseForProfit = $connection->quote( (double)$costBaseForProfit );		
		$costExtraLongNonProfit = $connection->quote( (double)$costExtraLongNonProfit );
		$costExtraLongForProfit = $connection->quote( (double)$costExtraLongForProfit );
		
		if(is_string($id))
		{
			$name = $connection->quote((ucwords(strtolower($id))));
			$exists = $connection->query("SELECT * FROM `EMAx_RoomLocation` WHERE name=" . $name );
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
				$create = $connection->exec(
					"INSERT INTO `EMAx_RoomLocation`(
						`name`, 
						`costBaseNonProfit`, 
						`costBaseForProfit`, 
						`costExtraLongNonProfit`, 
						`costExtraLongForProfit`
					) VALUES (
					{$name},
					{$costBaseNonProfit},
					{$costBaseForProfit},
					{$costExtraLongNonProfit},
					{$costExtraLongForProfit})"
				);
				
				$exists = $connection->query("SELECT * FROM `EMAx_RoomLocation` WHERE name=" . $name );
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
			$costBaseNonProfit = (double)$currentDBvalues->costBaseNonProfit;
			$costBaseForProfit = (double)$currentDBvalues->costBaseForProfit;
			$costExtraLongNonProfit = (double)$currentDBvalues->costExtraLongNonProfit;
			$costExtraLongForProfit = (double)$currentDBvalues->costExtraLongForProfit;
		}
		
		else
		{
			$id = NULL;
			$name = NULL;
			$notes = NULL;
			$costBaseNonProfit = 0.00;
			$costBaseForProfit = 0.00;
			$costExtraLongNonProfit = 0.00;
			$costExtraLongForProfit = 0.00;
		}
		
		$this->ClassObjectArg = array(
			'ID' => $id,
			'name' => $name,
			'notes' => $notes,	
			'costBaseNonProfit' => $costBaseNonProfit,	
			'costBaseForProfit' => $costBaseForProfit,
			'costExtraLongNonProfit' => $costExtraLongNonProfit,
			'costExtraLongForProfit' => $costExtraLongForProfit,
		);
	}

	public function getID()
	{
		return (int)$this->ClassObjectArg['ID'];
	}
	
	public function writeChanges()
	{
		$connection = new PDO('mysql:host='. EMAxSTATIC::$db_host .';dbname=' . EMAxSTATIC::$db_name, EMAxSTATIC::$db_user, EMAxSTATIC::$db_password);
		$name = $connection->quote($this->getRoomLocation());
		$cost = $connection->quote($this->getCost());
		$notes = $connection->quote($this->getnotes());
		$id = $connection->quote($this->getID());
		
		$sql = "UPDATE `EMAx_Option` SET `name`={$name},`cost`={$cost}, `notes`={$notes} WHERE `ID` = {$id}";
		$connection->exec($sql);
		$connection = NULL;	
	}
	
	public function deleteRecord()
	{
		
		$connection = new PDO('mysql:host='. EMAxSTATIC::$db_host .';dbname=' . EMAxSTATIC::$db_name, EMAxSTATIC::$db_user, EMAxSTATIC::$db_password);
		$id = $connection->quote($this->getID());
		$connection->exec("
			UPDATE `EMAx_Event` 
			SET `EMAx_Event`.`EMAx_RoomLocation_ID`= NULL 
			WHERE `EMAx_Event`.`EMAx_RoomLocation_ID`= " . $id
		);
		$connection->exec("DELETE FROM `EMAx_RoomLocation` WHERE `ID`=" . $id;
	}	
	
	public function getRoomLocation()
	{
		return $this->ClassObjectArg['name'];
	}
	
	public function getnotes()
	{
		return $this->ClassObjectArg['notes'];
	}

	public function getCostBaseNonProfit()  //`costBaseNonProfit`
	{
		return $this->ClassObjectArg['costBaseNonProfit'];	
	}
	
	public function setCostBaseNonProfit($value)
	{
		if(is_numeric($value))
		{
			$this->ClassObjectArg['costBaseNonProfit'] = (double)$value;
		}
	}	

	public function getCostBaseForProfit()  //`costBaseForProfit`
	{
		return $this->ClassObjectArg['costBaseForProfit'];	
	}
	
	public function setCostBaseForProfit($value)
	{
		if(is_numeric($value))
		{
			$this->ClassObjectArg['costBaseForProfit'] = (double)$value;
		}
	}	

	public function getCostExtraLongNonProfit()  // `costExtraLongNonProfit`
	{
		return $this->ClassObjectArg['costExtraLongNonProfit'];	
	}
	
	public function setCostExtraLongNonProfit($value)
	{
		if(is_numeric($value))
		{
			$this->ClassObjectArg['costExtraLongNonProfit'] = (double)$value;
		}
	}	
	
	public function getCostExtraLongForProfit() // `costExtraLongForProfit`
	{
		return $this->ClassObjectArg['costExtraLongForProfit'];	
	}
	
	public function setCostExtraLongForProfit($value)
	{
		if(is_numeric($value))
		{
			$this->ClassObjectArg['costExtraLongForProfit'] = (double)$value;
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
			$listArr[] = array( 
				'id' => $list['ID'], 
				'name' => $list['name'], 
				'costBaseNonProfit' => $list['costBaseNonProfit'],
				'costBaseForProfit' => $list['costBaseForProfit'],
				'costExtraLongNonProfit' => $list['costExtraLongNonProfit'],
				'costExtraLongForProfit' => $list['costExtraLongForProfit'],
			);
		}
		return $listArr;
	}
}
 
?>
