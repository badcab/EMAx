<?php
require_once('../configure/EMAxSTATIC.php');
class GradeModel
{
	private $ClassObjectArg;
	private $GradeList;
	
	function __construct($id = NULL, $cost = 0.00)
	{
		$connection = new PDO('mysql:host='. EMAxSTATIC::$db_host .';dbname=' . EMAxSTATIC::$db_name, EMAxSTATIC::$db_user, EMAxSTATIC::$db_password);
		$currentDBvalues = NULL;
		
		$gradeList = $connection->query("SELECT `ID`,`name`,`cost` FROM `EMAx_Grade`");
		$this->GradeList = $gradeList->fetchAll();	
		$id = ($id == '') ? NULL : $id;
		if(is_string($id))
		{
			$name = (ucwords(strtolower($id)));
			$exists = $connection->query("SELECT * FROM `EMAx_Grade` WHERE name=" . $connection->quote( $name ) );
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
				$connection->exec("INSERT INTO `EMAx_Grade`(`name`, `cost`) VALUES (" . $connection->quote( $name ) . ",". $connection->quote($cost) .")");
				$exists = $connection->query("SELECT * FROM `EMAx_Grade` WHERE name=" . $connection->quote( $name ) );
				$create = $exists->fetch(PDO::FETCH_OBJ);
				$id = (int)$create->ID;
			}	
		}
	
		if($id && is_int($id))
		{
			$result = $connection->query("SELECT * FROM `EMAx_Grade` WHERE ID=" . $connection->quote($id));
			$currentDBvalues = $result->fetch(PDO::FETCH_OBJ);
		}

		$connection = NULL;
		
		if($currentDBvalues)
		{
			$name = $currentDBvalues->name;
			$cost = $currentDBvalues->cost;
			$enable = $currentDBvalues->enable;					
		}
		
		else
		{
			$id = NULL;
			$name = NULL;
			$cost = 0.00;
			$enable = 1;
		}
		
		$this->ClassObjectArg = array(
			'ID' => $id,
			'name' => $name,
			'cost' => $cost,
			'enable' => $enable,		
		);
	}
	

	public function writeChanges()
	{
		$connection = new PDO('mysql:host='. EMAxSTATIC::$db_host .';dbname=' . EMAxSTATIC::$db_name, EMAxSTATIC::$db_user, EMAxSTATIC::$db_password);
		$name = $connection->quote($this->getGrade());
		$cost = $connection->quote($this->getCost());
		$id = $connection->quote($this->getID());
		$enable = $connection->quote($this->getEnable());
		
		$sql = "UPDATE `EMAx_Grade` SET `name`={$name},`cost`={$cost},`enable`={$enable} WHERE `ID` = {$id}";
		$connection->exec($sql);
		$connection = NULL;	
	}
	
	public function getID()
	{
		return (int)$this->ClassObjectArg['ID'];
	}
	
	public function deleteRecord()
	{
		
		$connection = new PDO('mysql:host='. EMAxSTATIC::$db_host .';dbname=' . EMAxSTATIC::$db_name, EMAxSTATIC::$db_user, EMAxSTATIC::$db_password);
		$id = $this->getID();
		$connection->exec("
			DELETE FROM `EMAx_GradeEventMap` 
			WHERE `EMAx_GradeEventMap`.`EMAx_Grade_ID`= " . $connection->quote($id) 
		);
		$connection->exec("DELETE FROM `EMAx_Grade` WHERE `ID`=" . $connection->quote($id) );
	}	
	
	public function getCost()
	{
		return $this->ClassObjectArg['cost'];	//remember to cast as double
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
	
	public function setEnable($value)
	{
		$this->ClassObjectArg['enable'] = ($value) ? 1 : 0;			
	}
	
	public function getEnable()
	{
		return (int)$this->ClassObjectArg['enable'];	
	}
	
	public function getFullList()
	{
		$listArr = array();
		foreach($this->GradeList as $list)	
		{
			$listArr[] = array( 'id' => $list['ID'], 'name' => $list['name'], 'cost' => $list['cost'], 'enable' => $list['enable']);
		}
		return $listArr;		
	}
	
	public function getList()//add claws so that only the enabled get returned
	{
		$listArr = array();
		foreach($this->GradeList as $list)	
		{
			if((int)$list['enable'])
			{
				$listArr[] = array( 'id' => $list['ID'], 'name' => $list['name'], 'cost' => $list['cost'], 'enable' => $list['enable']);	
			}
		}
		return $listArr;
	}
}
 
?>