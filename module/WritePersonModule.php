<?php
class WritePersonModule
{
	function __construct()
	{
		if(!isset($_SESSION)) 
		{ 
			session_start();
		} 			
	}

	public function activate($dataArray)
	{
		require_once('../model/PersonModel.php');
		require_once('../model/CityModel.php');
		require_once('../model/ZipModel.php');
		require_once('../model/OrganizationModel.php');
		require_once('../model/StateModel.php');
		
		$Person = new PersonModel((int)$dataArray['id']);
		$Organization = new OrganizationModel((int)$dataArray['Organization']);//==not defined
		$City = new CityModel($dataArray['City']);
		$Zip = new ZipModel($dataArray['Zip']);
		$State = new StateModel((int)$dataArray['State']);//==not defined
		
		$Person->setfName($dataArray['fName']);
		$Person->setmName($dataArray['mName']);
		$Person->setlName($dataArray['lName']);
		$Person->setphoneNumber($dataArray['phoneNumber']);
		$Person->setsecondaryPhoneNumber($dataArray['secondPhoneNumber']);
		$Person->setemailAddress($dataArray['emailAddress']);
		$Person->setaddress($dataArray['address']);
		$Person->setnotes($dataArray['notes']);		
		
		$Person->setState($State);
		$Person->setOrganization($Organization);
		$Person->setZip($Zip);
		$Person->setCity($City);

		$Person->writeData();
		
		return $Person->getID();
	}
}
?>
