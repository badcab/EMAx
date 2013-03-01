<?php
require_once('../configure/EMAxSTATIC.php');
class ZipModel
{
	private $ClassObjectArg;
	
	function __construct($id = NULL)
	{
		$connection = new PDO('mysql:host='. EMAxSTATIC::$db_host .';dbname=' . EMAxSTATIC::$db_name, EMAxSTATIC::$db_user, EMAxSTATIC::$db_password);
		$id = ($id == '') ? EMAxSTATIC::$IMPOSSIBLE_ZIP_CODE : $id;
		if(is_string($id))
		{
			if(is_null($id)) {return $id;}
			$name = (ucwords(strtolower($id)));
			$exists = $connection->query("SELECT * FROM `EMAx_Zip` WHERE name=" . $connection->quote( $name ) );
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
				$connection->exec("INSERT INTO `EMAx_Zip`(`name`) VALUES (" . $connection->quote( $name ) . ")");
				$exists = $connection->query("SELECT * FROM `EMAx_Zip` WHERE name=" . $connection->quote( $name ) );
				$create = $exists->fetch(PDO::FETCH_OBJ);
				$id = (int)$create->ID;
			}	
		}
		$currentDBvalues = NULL;
		if($id && is_int($id))//$success = $connection->exec($sql);	
		{
			$result = $connection->query("SELECT * FROM `EMAx_Zip` WHERE ID=" . $connection->quote($id));
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
		$connection = new PDO('mysql:host='. EMAxSTATIC::$db_host .';dbname=' . EMAxSTATIC::$db_name, EMAxSTATIC::$db_user, EMAxSTATIC::$db_password);
		$connection->exec("DELETE FROM `EMAx_Zip` WHERE `ID`=" . $connection->quote($this->getID()) );
	}	
	
	public function getZip()
	{
		return $this->ClassObjectArg['name'];
	}
	
	public function setZip($value)
	{
		$value = ($value == '') ? NULL : $value;
		$this->ClassObjectArg['name'] = ($value);
	}
}
 
?>