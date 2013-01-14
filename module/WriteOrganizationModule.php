<?php
class WriteOrganizationModule
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
		require_once('../model/OrganizationModel.php');
		require_once('../model/CityModel.php');
		require_once('../model/ZipModel.php');
		require_once('../model/StateModel.php');
//allow to be null		
		$Organization = new OrganizationModel((int)$dataArray['id']);
//in name modules ignore empty strings
//county
		$City = new CityModel($dataArray['City']);
		$Zip = new ZipModel($dataArray['Zip']);
		$State = new StateModel((int)$dataArray['State']);//==not defined
		
		$Organization->setname($dataArray['name']);
		$Organization->setphoneNumber($dataArray['phoneNumber']);
		$Organization->setemailAddress($dataArray['emailAddress']);
		$Organization->setaddress($dataArray['address']);
		$Organization->setnotes($dataArray['notes']);
		$Organization->setsameCounty($dataArray['county']);
		
		$Organization->setCity($City);
		$Organization->setZip($Zip);
		$Organization->setState($State);
		
		$Organization->writeData();
		
		return $Organization->getID();

	}
}
?>
