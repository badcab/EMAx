<?php

class GradeModel
{
	private $ClassObjectArg;
	private $GradeList;
	
	function __construct($id = NULL, $cost = 0.00)
	{
		require('../configure/db_connect.php');
		$connection = new PDO('mysql:host='. $db_host .';dbname=' . $db_name, $db_user, $db_password);
		$currentDBvalues = NULL;
		
		$gradeList = $connection->query("SELECT `ID`,`name`,`cost` FROM `EMAx_Grade`");
		$this->GradeList = $gradeList->fetchAll();	
		$id = ($id == '') ? NULL : $id;
		if(is_string($id))
		{
			$name = (ucwords(strtolower($id)));
			$exists = $connection->query("SELECT * FROM `EMAx_Grade` WHERE name='" . $name . "'");
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
				$connection->exec("INSERT INTO `EMAx_Grade`(`name`, `cost`) VALUES ('" . $name . "','". $cost ."')");
				$exists = $connection->query("SELECT * FROM `EMAx_Grade` WHERE name='" . $name . "'");
				$create = $exists->fetch(PDO::FETCH_OBJ);
				$id = (int)$create->ID;
			}	
		}
	
		if($id && is_int($id))
		{
			$result = $connection->query("SELECT * FROM `EMAx_Grade` WHERE ID=" . $id);
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
//			$cost = 0.00
		}
		
		$this->ClassObjectArg = array(
			'ID' => $id,
			'name' => $name,
//			'cost' => $cost		
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
			DELETE FROM `EMAx_GradeEventMap` 
			WHERE `EMAx_GradeEventMap`.`EMAx_Grade_ID`= '" .$id . "'"
		);
		$connection->exec("DELETE FROM `EMAx_Grade` WHERE `ID`='" . $id . "'");
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
	
	public function getGrade()
	{
		return $this->ClassObjectArg['name'];	
	}
	
	public function setGrade($value)
	{
		$value = ($value == '') ? NULL : $value;
		$this->ClassObjectArg['name'] = (ucwords(strtolower($value)));
	}
	
	public function getList()
	{
		$listArr = array();
		foreach($this->GradeList as $list)	
		{
			$listArr[] = array( 'id' => $list['ID'], 'name' => $list['name'], 'cost' => $list['cost']);
		}
		return $listArr;
	}
}
 
?>