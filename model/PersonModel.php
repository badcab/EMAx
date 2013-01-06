<?php
require_once('../configure/EMAxSTATIC.php');
require_once('CityModel.php');
require_once('StateModel.php');
require_once('ZipModel.php');
require_once('OrganizationModel.php');
class PersonModel
{
	private $ClassObjectArg;
	
	function __construct($id = NULL)
	{
		$currentDBvalues = NULL;
		
		$connection = new PDO('mysql:host='. EMAxSTATIC::$db_host .';dbname=' . EMAxSTATIC::$db_name, EMAxSTATIC::$db_user, EMAxSTATIC::$db_password);
		if($id)
		{
			$result = $connection->query("SELECT * FROM `EMAx_Person` WHERE ID=" . $connection->quote($id));
			$currentDBvalues  = ($result) ? $result->fetch(PDO::FETCH_OBJ) : NULL ;
		}
		$connection = NULL;
		
		if($currentDBvalues)
		{
			$fName = $currentDBvalues->fName;
			$mName = $currentDBvalues->mName;
			$lName = $currentDBvalues->lName;
			$phoneNumber = $currentDBvalues->phoneNumber;
			$secondaryPhoneNumber = $currentDBvalues->secondaryPhoneNumber;
			$emailAddress = $currentDBvalues->emailAddress;
			$address = $currentDBvalues->address;
			$notes = $currentDBvalues->notes;
			$City = $currentDBvalues->EMAx_City_ID;
			$State = $currentDBvalues->EMAx_State_ID;
			$Zip = $currentDBvalues->EMAx_Zip_ID;
			$Organization = $currentDBvalues->EMAx_Organization_ID;
		}
		
		else
		{
			$id = NULL; 
			$fName = NULL;
			$mName = NULL;
			$lName = NULL;
			$phoneNumber = NULL;
			$secondaryPhoneNumber = NULL;
			$emailAddress = NULL;
			$address = NULL;
			$notes = NULL;
			$City = NULL;
			$State = NULL;
			$Zip = NULL;
			$Organization = NULL;
		}
		
		$this->ClassObjectArg = array(
			'ID' => $id,		
			'fName' => $fName,
			'mName' => $mName,
			'lName' => $lName,
			'phoneNumber' => $phoneNumber,
			'secondaryPhoneNumber' => $secondaryPhoneNumber,
			'emailAddress' => $emailAddress,
			'address' => $address,
			'notes' => $notes,
			'City' => $City,
			'State' => $State,
			'Zip' => $Zip,
			'Organization' => $Organization
		);
	}

	public function writeData()
	{
		
		$connection = new PDO('mysql:host='. EMAxSTATIC::$db_host .';dbname=' . EMAxSTATIC::$db_name, EMAxSTATIC::$db_user, EMAxSTATIC::$db_password);
		$zip = ($this->ClassObjectArg['Zip']) ? "'" . $this->ClassObjectArg['Zip'] . "'" : 'NULL' ;
		$city = ($this->ClassObjectArg['City']) ? "'" . $this->ClassObjectArg['City'] . "'" : 'NULL' ;
		if($this->ClassObjectArg['ID'])
		{
//			$result = $connection->query("SELECT * FROM `EMAx_Person` WHERE ID=" . $id);
			$sql = "UPDATE `EMAx_Person` SET `fName`='". $connection->quote($this->ClassObjectArg['fName'])  
				."',`mName`='". $connection->quote($this->ClassObjectArg['mName'])  
				."',`lName`='". $connection->quote($this->ClassObjectArg['lName']) 
				."',`phoneNumber`='". $connection->quote($this->ClassObjectArg['phoneNumber'])  
				."',`secondaryPhoneNumber`='". $connection->quote($this->ClassObjectArg['secondaryPhoneNumber'])  
				."',`emailAddress`='". $connection->quote($this->ClassObjectArg['emailAddress'])  
				."',`address`='". $connection->quote($this->ClassObjectArg['address'])  
				."',`notes`='". $connection->quote($this->ClassObjectArg['notes'])  
				."',`EMAx_City_ID`=". $connection->quote($city)  
				.",`EMAx_State_ID`='". $connection->quote($this->ClassObjectArg['State'])  
				."',`EMAx_Zip_ID`=". $connection->quote($zip)
				.",`EMAx_Organization_ID`='". $connection->quote($this->ClassObjectArg['Organization'])  
				."' WHERE `ID`='" . $connection->quote($this->ClassObjectArg['ID']) . "'";
		}
		
		else
		{
//			$result = $connection->query("SELECT * FROM `EMAx_Person` WHERE ID=" . $id);	
			$sql =
				"INSERT INTO `EMAx_Person`(
					`fName`, 
					`mName`, 
					`lName`, 
					`phoneNumber`, 
					`secondaryPhoneNumber`, 
					`emailAddress`, 
					`address`, 
					`notes`, 
					`EMAx_City_ID`, 
					`EMAx_State_ID`, 
					`EMAx_Zip_ID`, 
					`EMAx_Organization_ID`
				) VALUES (
					'". $connection->quote($this->ClassObjectArg['fName']) ."',
					'". $connection->quote($this->ClassObjectArg['mName']) ."',
					'". $connection->quote($this->ClassObjectArg['lName']) ."',
					'". $connection->quote($this->ClassObjectArg['phoneNumber']) ."',
					'". $connection->quote($this->ClassObjectArg['secondaryPhoneNumber']) ."',
					'". $connection->quote($this->ClassObjectArg['emailAddress']) ."',
					'". $connection->quote($this->ClassObjectArg['address']) ."',
					'". $connection->quote($this->ClassObjectArg['notes']) ."',
					". $connection->quote($city) .",
					'". $connection->quote($this->ClassObjectArg['State']) ."',
					". $connection->quote($zip) .",
					'". $connection->quote($this->ClassObjectArg['Organization']) ."'
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
		
		$connection = new PDO('mysql:host='. EMAxSTATIC::$db_host .';dbname=' . EMAxSTATIC::$db_name, EMAxSTATIC::$db_user, EMAxSTATIC::$db_password);
		$connection->exec("UPDATE `EMAx_Event` SET `EMAx_Person_ID`= NULL WHERE `EMAx_Person_ID` = '". $connection->quote($this->getID()) ."'");
		$connection->exec("DELETE FROM `EMAx_Person` WHERE `ID`='" . $connection->quote($this->getID()) . "'");
	}	

	public function getfName()
	{
		return $this->ClassObjectArg['fName'];
	}

	public function getmName()
	{
		return $this->ClassObjectArg['mName'];
	}

	public function getlName()
	{
		return $this->ClassObjectArg['lName'];
	}

	public function getphoneNumber()
	{
		return $this->ClassObjectArg['phoneNumber'];
	}

	public function getsecondaryPhoneNumber()
	{
		return $this->ClassObjectArg['secondaryPhoneNumber'];
	}

	public function getemailAddress()
	{
		return $this->ClassObjectArg['emailAddress'];
	}

	public function getaddress()
	{
		return $this->ClassObjectArg['address'];
	}

	public function getnotes()
	{
		return $this->ClassObjectArg['notes'];
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

	public function getOrganization()
	{
		$Organization = new OrganizationModel((int)$this->ClassObjectArg['Organization']);
		return $Organization;
	}
	
	public function setfName($value)
	{
		$value = ($value == '') ? NULL : $value;
		$this->ClassObjectArg['fName'] = ($value);
	}

	public function setmName($value)
	{
		$value = ($value == '') ? NULL : $value;
		$this->ClassObjectArg['mName'] = ($value);
	}

	public function setlName($value)
	{
		$value = ($value == '') ? NULL : $value;
		$this->ClassObjectArg['lName'] = ($value);
	}

	public function setphoneNumber($value)
	{
		$value = ($value == '') ? NULL : $value;
		$this->ClassObjectArg['phoneNumber'] = ($value);
	}

	public function setsecondaryPhoneNumber($value)
	{
		$value = ($value == '') ? NULL : $value;
		$this->ClassObjectArg['secondaryPhoneNumber'] = ($value);
	}

	public function setemailAddress($value)
	{
		$value = ($value == '') ? NULL : $value;
		$this->ClassObjectArg['emailAddress'] = ($value);
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

	public function setOrganization(OrganizationModel $value)
	{
		$this->ClassObjectArg['Organization'] = (int)$value->getID();
	}
	
	public function getListByOrganization(OrganizationModel $value)
	{
		$OrgID = (int)$value->getID();
		
		$connection = new PDO('mysql:host='. EMAxSTATIC::$db_host .';dbname=' . EMAxSTATIC::$db_name, EMAxSTATIC::$db_user, EMAxSTATIC::$db_password);
		
		$result = $connection->query("SELECT `ID`,`fName`,`lName` FROM `EMAx_Person` WHERE `EMAx_Organization_ID` = " . $connection->quote($OrgID));	
		$personList = ($result) ? $result->fetchAll() : NULL ;
		
		$listArr = array();
		foreach($personList as $list)	
		{
			$listArr[] = array( 'id' => $list['ID'], 'name' => $list['fName'] . ' ' . $list['lName']);
		}
		return $listArr;	
		
	}
}
 
?>