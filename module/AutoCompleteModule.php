<?php
require_once('../model/CityModel.php');
require_once('../model/StateModel.php');
require_once('../model/ZipModel.php');
require_once('../model/OrganizationModel.php');
require_once('../model/PersonModel.php');
require_once('../model/RoomLocationModel.php');
require_once('../model/LoginModel.php');
require_once('../configure/EMAxSTATIC.php');
class AutoCompleteModule
{
	private $personList;
	private $orgList;
	private $EventList;

	function __construct()
	{
		$connection = new PDO('mysql:host='. EMAxSTATIC::$db_host .';dbname=' . EMAxSTATIC::$db_name, EMAxSTATIC::$db_user, EMAxSTATIC::$db_password);
		$this->personList = array();
		$queryResult = $connection->query('SELECT * FROM `EMAx_Person`');
		$personList = ($queryResult) ? $queryResult->fetchAll() : array();
		foreach($personList as $row)
		{
    		$this->personList[] = 
    		   $row['fName'] . ' ' .
    			$row['mName'] . ' ' .
    			$row['lName'];
		}
		sort($this->personList);

		$this->orgList = array();
		$queryResult = $connection->query('SELECT * FROM `EMAx_Organization`');
		$orgList = ($queryResult) ? $queryResult->fetchAll() : array();
		foreach($orgList as $row)
		{
    		$this->orgList[] =
    			$row['name'];
		}
		sort($this->orgList);

	}

	public function activate()
	{	
		$result = array_merge($this->personList, $this->orgList);
		return $result;
	}
}
?>