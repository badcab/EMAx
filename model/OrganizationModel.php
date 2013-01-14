<?php
require_once('../configure/EMAxSTATIC.php');
require_once('CityModel.php');
require_once('StateModel.php');
require_once('ZipModel.php');
class OrganizationModel
{
	private $ClassObjectArg;
	private $OrganizationList;
	function __construct($id = NULL)
	{
		$connection = new PDO('mysql:host='. EMAxSTATIC::$db_host .';dbname=' . EMAxSTATIC::$db_name, EMAxSTATIC::$db_user, EMAxSTATIC::$db_password);
		$currentDBvalues = NULL;
		if($id)
		{
			$result = $connection->query("SELECT * FROM `EMAx_Organization` WHERE ID=" . $connection->quote($id));
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
			$sameCounty = $currentDBvalues->sameCounty;
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
			$sameCounty = NULL;
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
			'notes' => $notes,
			'sameCounty' => $sameCounty
		);
	}
	public function writeData()
	{
		$connection = new PDO('mysql:host='. EMAxSTATIC::$db_host .';dbname=' . EMAxSTATIC::$db_name, EMAxSTATIC::$db_user, EMAxSTATIC::$db_password);

		if($this->ClassObjectArg['ID'])
		{
			$sql = "
				UPDATE `EMAx_Organization` SET `name`=". $connection->quote($this->ClassObjectArg['name'])
				.",`phoneNumber`=". $connection->quote($this->ClassObjectArg['phoneNumber'])
				.",`emailAddress`=". $connection->quote($this->ClassObjectArg['emailAddress'])
				.",`EMAx_City_ID`=". $connection->quote($this->ClassObjectArg['City'])
				.",`EMAx_State_ID`=". $connection->quote($this->ClassObjectArg['State'])
				.",`EMAx_Zip_ID`=". $connection->quote($this->ClassObjectArg['Zip'])
				.",`address`=". $connection->quote($this->ClassObjectArg['address'])
				.",`notes`=". $connection->quote($this->ClassObjectArg['notes'])
				.",`sameCounty`=". $connection->quote($this->ClassObjectArg['sameCounty'])
				." WHERE `ID`=" . $connection->quote($this->ClassObjectArg['ID']);
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
					`notes`,
					`sameCounty`
				) VALUES (
					". $connection->quote($this->ClassObjectArg['name']) .",
					". $connection->quote($this->ClassObjectArg['phoneNumber']) .",
					". $connection->quote($this->ClassObjectArg['emailAddress']) .",
					". $connection->quote($this->ClassObjectArg['City']) .",
					". $connection->quote($this->ClassObjectArg['State']) .",
					". $connection->quote($this->ClassObjectArg['Zip']) .",
					". $connection->quote($this->ClassObjectArg['address']) .",
					". $connection->quote($this->ClassObjectArg['notes']) .",
					". $connection->quote($this->ClassObjectArg['sameCounty']) ."
				)";
		}
		$connection->beginTransaction();
			$connection->exec($sql);
			$lastInsertedID = $connection->lastInsertId();
		$connection->commit();
		$this->ClassObjectArg['ID'] = (int)$lastInsertedID;
		$success = $lastInsertedID;
		$connection = NULL;

//error_log("the id is: " . $lastInsertedID );
//error_log($sql);

		return $success; //maybe I shall remove this line and just use get ID?
		
	}
	public function getID()
	{
		return (int)$this->ClassObjectArg['ID'];
	}
	public function deleteRecord()
	{
		$connection = new PDO('mysql:host='. EMAxSTATIC::$db_host .';dbname=' . EMAxSTATIC::$db_name, EMAxSTATIC::$db_user, EMAxSTATIC::$db_password);
		$connection->exec("UPDATE `EMAx_Person` SET `EMAx_Organization_ID`= NULL WHERE `EMAx_Organization_ID` =". $connection->quote($this->getID()) );
		$connection->exec("DELETE FROM `EMAx_Event` WHERE `EMAx_Organization_ID`=" . $connection->quote($this->getID()) );
		$connection->exec("DELETE FROM `EMAx_Organization` WHERE `ID`=" . $connection->quote($this->getID()) );
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
		$this->ClassObjectArg['name'] = $value;
	}
	public function setphoneNumber($value)
	{
		$value = ($value == '') ? NULL : $value;
		$this->ClassObjectArg['phoneNumber'] = $value;
	}
	public function setemailAddress($value)
	{
		$value = ($value == '') ? NULL : $value;
		$this->ClassObjectArg['emailAddress'] = $value;
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
		$this->ClassObjectArg['address'] = $value;
	}
	public function setnotes($value)
	{
		$value = ($value == '') ? NULL : $value;
		$this->ClassObjectArg['notes'] = $value;
	}
	public function getList()
	{
		$listArr = array();
		foreach($this->OrganizationList as $list)
		{
			$listArr[] = array( 'id' => $list['ID'], 'name' => $list['name']);
		}
		return $listArr;
	}
	public function getsameCounty()
	{
		return $this->ClassObjectArg['sameCounty'];
	}

	public function setsameCounty($value)
	{
		$value = ($value == '') ? NULL : $value;
		$this->ClassObjectArg['sameCounty'] = (int)$value;
	}	
}
?>
