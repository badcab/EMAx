<?php
require_once('../configure/EMAxSTATIC.php');
class OptionModel
{
	private $ClassObjectArg;
	private $OptionList;
	
	function __construct($id = NULL, $cost = 0.00)
	{
		
		$connection = new PDO('mysql:host='. EMAxSTATIC::$db_host .';dbname=' . EMAxSTATIC::$db_name, EMAxSTATIC::$db_user, EMAxSTATIC::$db_password);
		$currentDBvalues = NULL;
		
		$optionList = $connection->query("SELECT `ID`,`name`,`cost` FROM `EMAx_Option` ORDER BY `name`");
		$this->OptionList = $optionList->fetchAll();	
		$id = ($id == '') ? NULL : $id;
		if(is_string($id))
		{
			$name = (ucwords(strtolower($id)));
			$exists = $connection->query("SELECT * FROM `EMAx_Option` WHERE name=" . $connection->quote( $name ) );
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
				$connection->exec("INSERT INTO `EMAx_Option`(`name`, `cost`) VALUES (" . $connection->quote( $name ) . ",". $connection->quote($cost) .")");
				$exists = $connection->query("SELECT * FROM `EMAx_Option` WHERE name=" . $connection->quote( $name ) );
				$create = $exists->fetch(PDO::FETCH_OBJ);
				$id = (int)$create->ID;
			}	
		}
	
		if($id && is_int($id))
		{
			$result = $connection->query("SELECT * FROM `EMAx_Option` WHERE ID=" . $connection->quote($id));
			$currentDBvalues = $result->fetch(PDO::FETCH_OBJ);
		}
		
		$connection = NULL;
		
		if($currentDBvalues)
		{
			$name = $currentDBvalues->name;
			$cost = $currentDBvalues->cost;
		}
		
		else
		{
			$id = NULL;
			$name = NULL;
//			$cost = 0.00; since this is already declared we are all good
		}
		
		$this->ClassObjectArg = array(
			'ID' => $id,
			'name' => $name,
			'cost' => $cost		
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
		/*handle dependancies*/
		$connection->exec("
			DELETE FROM `EMAx_OptionEventMap` 
			WHERE `EMAx_OptionEventMap`.`EMAx_Option_ID`= " . $connection->quote($id) 
		);
		$connection->exec("DELETE FROM `EMAx_Option` WHERE `ID`=" . $connection->quote($id) );
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
	
	public function getOption()
	{
		return $this->ClassObjectArg['name'];	
	}
	
	public function setOption($value)
	{
		$value = ($value == '') ? NULL : $value;
		$this->ClassObjectArg['name'] = (ucwords(strtolower($value)));
	}
	
	public function getList()
	{
		$listArr = array();
		foreach($this->OptionList as $list)	
		{
			$listArr[] = array( 'id' => $list['ID'], 'name' => $list['name'], 'cost' => $list['cost']);
		}
		return $listArr;
	}
}
 
?>