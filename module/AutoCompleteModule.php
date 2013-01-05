<?php
require_once('../model/CityModel.php');
require_once('../model/StateModel.php');
require_once('../model/ZipModel.php');
require_once('../model/OrganizationModel.php');
require_once('../model/PersonModel.php');
require_once('../model/RoomLocationModel.php');
require_once('../model/LoginModel.php');

class AutoCompleteModule
{
	private $personList;
	private $orgList;
	private $EventList;

/*
$queryResult = $this->connection->query($sqlPerson);
		$queryArr = ($queryResult) ? $queryResult->fetchAll() : array();
		foreach($queryArr as $record)	
*/

	function __construct()
	{
		require('../configure/db_connect.php');
		$connection = new PDO('mysql:host='. $db_host .';dbname=' . $db_name, $db_user, $db_password);
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
//=====================================
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