<?php
require_once('../configure/EMAxSTATIC.php');
class CityModel
{
	private $ClassObjectArg;
	private $cityList;
	
	function __construct($id = NULL)//is_ numeric
	{
		
		$connection = new PDO('mysql:host='. EMAxSTATIC::$db_host .';dbname=' . EMAxSTATIC::$db_name, EMAxSTATIC::$db_user, EMAxSTATIC::$db_password);
		$id = ($id == '') ? NULL : $id;
		
		if(is_string($id))
		{
			if(is_null($id)) {return $id;}
			$name = (ucwords(strtolower($id)));
			$sql = "SELECT * FROM `EMAx_City` WHERE name=" . $connection->quote( $name );
			$exists = $connection->query( $sql );
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
				$sql = "INSERT INTO `EMAx_City`(`name`) VALUES (" . $connection->quote( $name ). ")";
				$connection->exec( $sql );
				
				$sql = "SELECT * FROM `EMAx_City` WHERE name=" . $connection->quote( $name );
				$exists = $connection->query( $sql );
				$create = $exists->fetch(PDO::FETCH_OBJ);
				$id = (int)$create->ID;
			}	
		}
		
		$currentDBvalues = NULL;
		
		if($id && is_int($id))
		{
			$result = $connection->query("SELECT * FROM `EMAx_City` WHERE ID=" . $connection->quote($id));
			$currentDBvalues = $result->fetch(PDO::FETCH_OBJ);
		}
		
		$cityList = $connection->query("SELECT * FROM `EMAx_City`");
		$this->cityList = $cityList->fetchAll(); 
		
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
		$connection->exec("DELETE FROM `EMAx_City` WHERE `ID`=" . $connection->quote( $this->getID() ) );
	}
	
	public function getCity()
	{
		return $this->ClassObjectArg['name'];	
	}
	
	public function setCity($value)
	{
		$value = ($value == '') ? NULL : $value;
		$this->ClassObjectArg['name'] = (ucwords(strtolower($value)));
	}
	
	public function getList()
	{
		$listArr = array();
		foreach($this->cityList as $list)	
		{
			$listArr[] = array( 'id' => $list['ID'], 'name' => $list['name']);
		}
		return $listArr;
	}
}
 
?>