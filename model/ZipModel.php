<?php

class ZipModel
{
	private $ClassObjectArg;
	
	function __construct($id = NULL)
	{
		require('../configure/db_connect.php');
		$connection = new PDO('mysql:host='. $db_host .';dbname=' . $db_name, $db_user, $db_password);
		$id = ($id == '') ? NULL : $id;
		if(is_string($id))
		{
			if(is_null($id)) {return $id;}
			$name = (ucwords(strtolower($id)));
			$exists = $connection->query("SELECT * FROM `EMAx_Zip` WHERE name='" . $name . "')");
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
				//if(/*lenght is 5 and all are numerical*/){}
				$connection->exec("INSERT INTO `EMAx_Zip`(`name`) VALUES ('" . $name . "')");
				$exists = $connection->query("SELECT * FROM `EMAx_Zip` WHERE name='" . $name . "'");
				$create = $exists->fetch(PDO::FETCH_OBJ);
				$id = (int)$create->ID;
			}	
		}
		$currentDBvalues = NULL;
		if($id && is_int($id))//$success = $connection->exec($sql);	
		{
			$result = $connection->query("SELECT * FROM `EMAx_Zip` WHERE ID=" . $id);
			$currentDBvalues = $result->fetch(PDO::FETCH_OBJ);
		}
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
		$connection->exec("DELETE FROM `EMAx_Zip` WHERE `ID`='" . getID() . "'");
	}	
	
	public function getZip()
	{
		return $this->ClassObjectArg['name'];
	}
	
	public function setZip($value)
	{
		$value = ($value == '') ? NULL : $value;
		//if is numerical
		//if lengh is 5
		$this->ClassObjectArg['name'] = ($value);
	}
}
 
?>