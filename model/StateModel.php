<?php
require_once('../configure/EMAxSTATIC.php');
class StateModel
{
	private $ClassObjectArg;
	private $stateList;
	
	function __construct($id = NULL)
	{
		$currentDBvalues = NULL;
		
		$connection = new PDO('mysql:host='. EMAxSTATIC::$db_host .';dbname=' . EMAxSTATIC::$db_name, EMAxSTATIC::$db_user, EMAxSTATIC::$db_password);
		$id = ($id == '') ? NULL : $id;
		if(is_string($id))
		{
			if(is_null($id)) {return $id;}
			$name = (ucwords(strtolower($id)));
			$exists = $connection->query("SELECT * FROM `EMAx_State` WHERE name=" . $connection->quote( $name ) );
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
				$create = $connection->exec("INSERT INTO `EMAx_State`(`name`) VALUES (" . $connection->quote( $name ) . ")");
				$exists = $connection->query("SELECT * FROM `EMAx_State` WHERE name=" . $connection->quote( $name ) );
				$createReturn = $exists->fetch(PDO::FETCH_OBJ);
				$id = (int)$createReturn->ID;
			}	
		}
	
		if($id && is_int($id))
		{
			$result = $connection->query("SELECT * FROM `EMAx_State` WHERE ID=" . $connection->quote($id));
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
		
		$connection = new PDO('mysql:host='. EMAxSTATIC::$db_host .';dbname=' . EMAxSTATIC::$db_name, EMAxSTATIC::$db_user, EMAxSTATIC::$db_password);
		$id = $this->getID();
//this is a fk code that should be handeled by triggers
		$connection->exec("
			UPDATE `EMAx_Person` 
			SET `EMAx_Person`.`EMAx_State_ID`= NULL 
			WHERE `EMAx_Person`.`EMAx_State_ID`= " . $connection->quote($id)
		);
		$connection->exec("
			UPDATE `EMAx_Organization` 
			SET `EMAx_Organization`.`EMAx_State_ID`= NULL 
			WHERE `EMAx_Organization`.`EMAx_State_ID`= " . $connection->quote($id)
		);

		$connection->exec("DELETE FROM `EMAx_State` WHERE `ID`= " . $connection->quote($id) );
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