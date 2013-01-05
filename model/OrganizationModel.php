<?php
 
require_once('CityModel.php');
require_once('StateModel.php');
require_once('ZipModel.php');
class OrganizationModel
{
	private $ClassObjectArg;
	private $OrganizationList;
	
	function __construct($id = NULL)
	{
		require('../configure/db_connect.php');
		$connection = new PDO('mysql:host='. $db_host .';dbname=' . $db_name, $db_user, $db_password);
		$currentDBvalues = NULL;
		if($id)
		{
			$result = $connection->query("SELECT * FROM `EMAx_Organization` WHERE ID=" . $id);
			$currentDBvalues  = ($result) ? $result->fetch(PDO::FETCH_OBJ) : NULL ;
		}
		
		$organizationList = $connection->query("SELECT `ID`,`name` FROM `EMAx_Organization`");
		$this->OrganizationList = $organizationList->fetchAll();	
		
		$connection = NULL;
		if($currentDBvalues)
		{
			$City = $currentDBvalues->EMAx_City_ID;
			$State = $currentDBvalues->EMAx_State_ID;
			$Zip = $currentDBvalues->EMAx_Zip_ID;
			$name = $currentDBvalues->name;
			$phoneNumber = $currentDBvalues->phoneNumber;
			$emailAddress = $currentDBvalues->emailAddress;
			$address = $currentDBvalues->address;
			$notes = $currentDBvalues->notes;		
		}
		
		else
		{
			$id = NULL;
			$name = NULL;
			$phoneNumber = NULL;
			$emailAddress = NULL;
			$City = NULL;
			$State = NULL;
			$Zip = NULL;
			$address = NULL;
			$notes = NULL;
		}
		
		$this->ClassObjectArg = array(
			'ID' => $id,
			'name' => $name,
			'phoneNumber' => $phoneNumber,
			'emailAddress' => $emailAddress,
			'City' => $City,
			'State' => $State,
			'Zip' => $Zip,
			'address' => $address,
			'notes' => $notes		
		);
	}

	public function writeData()
	{
		require('../configure/db_connect.php');
		$connection = new PDO('mysql:host='. $db_host .';dbname=' . $db_name, $db_user, $db_password);
		$zip = ($this->ClassObjectArg['Zip']) ? "'" . $this->ClassObjectArg['Zip'] . "'" : 'NULL' ;
		$city = ($this->ClassObjectArg['City']) ? "'" . $this->ClassObjectArg['City'] . "'" : 'NULL' ;
		if($this->ClassObjectArg['ID'])
		{
			$sql = "		
				UPDATE `EMAx_Organization` SET `name`='". $this->ClassObjectArg['name']  
				."',`phoneNumber`='". $this->ClassObjectArg['phoneNumber']  
				."',`emailAddress`='". $this->ClassObjectArg['emailAddress']  
				."',`EMAx_City_ID`=". $city  
				.",`EMAx_State_ID`='". $this->ClassObjectArg['State']  
				."',`EMAx_Zip_ID`=". $zip  
				.",`address`='". $this->ClassObjectArg['address']  
				."',`notes`='". $this->ClassObjectArg['notes']  
				."' WHERE `ID`='" . $this->ClassObjectArg['ID'] . "'";
			
		}
		
		else
		{
			$sql = 
				"INSERT INTO `EMAx_Organization`(
					`name`, 
					`phoneNumber`, 
					`emailAddress`, 
					`EMAx_City_ID`, 
					`EMAx_State_ID`, 
					`EMAx_Zip_ID`, 
					`address`, 
					`notes`
				) VALUES (
					'". $this->ClassObjectArg['name'] ."',
					'". $this->ClassObjectArg['phoneNumber'] ."',
					'". $this->ClassObjectArg['emailAddress'] ."',
					". $city .",
					'". $this->ClassObjectArg['State'] ."',
					". $zip .",
					'". $this->ClassObjectArg['address'] ."',
					'". $this->ClassObjectArg['notes'] ."'
				)";
		}
		$connection->beginTransaction();
			$connection->exec($sql);
			$lastInsertedID = $connection->lastInsertId();
		$connection->commit();
		$this->ClassObjectArg['ID'] = (int)$lastInsertedID;	
		$success = $lastInsertedID;
		$connection = NULL;	
		return $success;	
	}
		
	public function getID()
	{
		return (int)$this->ClassObjectArg['ID'];
	}
	
	public function deleteRecord()
	{
		require('../configure/db_connect.php');
		$connection = new PDO('mysql:host='. $db_host .';dbname=' . $db_name, $db_user, $db_password);
		$connection->exec("UPDATE `EMAx_Person` SET `EMAx_Organization_ID`= NULL WHERE `EMAx_Organization_ID` = '". $this->getID() ."'");
		$connection->exec("DELETE FROM `EMAx_Event` WHERE `EMAx_Organization_ID`= '" . $this->getID() . "'");
		$connection->exec("DELETE FROM `EMAx_Organization` WHERE `ID`='" . $this->getID() . "'");
	}	
	
	public function getOrganization()
	{
		return $this->ClassObjectArg['name'];
	}
	
	public function getphoneNumber()
	{
		return $this->ClassObjectArg['phoneNumber'];
	}
	
	public function getemailAddress()
	{
		return $this->ClassObjectArg['emailAddress'];
	}
	
	public function getCity()
	{
		$City = new CityModel((int)$this->ClassObjectArg['City']);
		return $City;
	}
	
	public function getState()
	{
		$State = new StateModel((int)$this->ClassObjectArg['State']);
		return $State;
	}
	
	public function getZip()
	{
		$Zip = new ZipModel((int)$this->ClassObjectArg['Zip']);
		return $Zip;
	}
	
	public function getaddress()
	{
		return $this->ClassObjectArg['address'];
	}
	
	public function getnotes()
	{
		return $this->ClassObjectArg['notes'];
	}
	
	public function setname($value)
	{
		$value = ($value == '') ? NULL : $value;
		$this->ClassObjectArg['name'] = ($value);
	}
	
	public function setphoneNumber($value)
	{
		$value = ($value == '') ? NULL : $value;
		$this->ClassObjectArg['phoneNumber'] = ($value);
	}
	
	public function setemailAddress($value)
	{
		$value = ($value == '') ? NULL : $value;
		$this->ClassObjectArg['emailAddress'] = ($value);
	}
	
	public function setCity(CityModel $value)
	{
		$this->ClassObjectArg['City'] = (int)$value->getID();
	}
	
	public function setState(StateModel $value)
	{
		$this->ClassObjectArg['State'] = (int)$value->getID();
	}
	
	public function setZip(ZipModel $value)
	{
		$this->ClassObjectArg['Zip'] = (int)$value->getID();
	}
	
	public function setaddress($value)
	{
		$value = ($value == '') ? NULL : $value;
		$this->ClassObjectArg['address'] = ($value);
	}
	
	public function setnotes($value)
	{
		$value = ($value == '') ? NULL : $value;
		$this->ClassObjectArg['notes'] = ($value);
	}
	
	public function getList()
	{	
		$listArr = array();
		foreach($this->OrganizationList as $list)	
		{
			$listArr[$list['ID']] = $list['name'];
		}
		return $listArr;
	}
}
 
?>