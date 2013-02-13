<?php
require_once('../configure/EMAxSTATIC.php');
class _SearchModel
{
	private $connection;
	private $results;
	private $sqlBasePerson = "
		SELECT DISTINCT
		`EMAx_Person`.`ID` ,
		`EMAx_Person`.`fName`,
		`EMAx_Person`.`mName` ,
		`EMAx_Person`.`lName` ,
		`EMAx_Person`.`address` ,
		`EMAx_Person`.`emailAddress` ,
		`EMAx_Person`.`secondaryPhoneNumber` ,
		`EMAx_Person`.`phoneNumber`,
		`EMAx_Person`.`EMAx_Organization_ID`,
		`EMAx_Organization`.`name` as `Organization`,
		`EMAx_Zip`.`name` as `Zip`,
		`EMAx_State`.`name` as `State`,
		`EMAx_City`.`name` as `City`
		FROM  `EMAx_Person`
		JOIN  `EMAx_Organization` , `EMAx_Zip` , `EMAx_State` , `EMAx_City`, `EMAx_Event`
		WHERE  `EMAx_Person`.`EMAx_Organization_ID` =  `EMAx_Organization`.`ID`
		AND  `EMAx_Person`.`EMAx_State_ID` =  `EMAx_State`.`ID`
		AND  `EMAx_Person`.`EMAx_Zip_ID` =  `EMAx_Zip`.`ID`
		AND  `EMAx_Person`.`EMAx_City_ID` =  `EMAx_City`.`ID`
	";
	private $sqlBaseEvent = "
		SELECT DISTINCT
		`EMAx_Event`.`ID` ,
		`EMAx_Event`.`endTime` ,
		`EMAx_Event`.`startTime` ,
		`EMAx_Login`.`userName` as `bookedBy`,
		`EMAx_RoomLocation`.`name` as `RoomLocation`,
		`EMAx_Organization`.`name` as `Organization`,
		`EMAx_Person`.`fName` ,
		`EMAx_Person`.`mName` ,
		`EMAx_Person`.`lName` ,
		`EMAx_Person`.`phoneNumber` ,
		`EMAx_Person`.`emailAddress`,
		`EMAx_Event`.`EMAx_Person_ID`,
		`EMAx_Event`.`EMAx_Organization_ID`
		FROM  `EMAx_Event`
		JOIN  `EMAx_Login` , `EMAx_Organization` , `EMAx_Person` , `EMAx_RoomLocation`
		WHERE  `EMAx_Event`.`EMAx_Organization_ID` =  `EMAx_Organization`.`ID`
		AND  `EMAx_Event`.`EMAx_Login_ID` =  `EMAx_Login`.`ID`
		AND  `EMAx_Event`.`EMAx_RoomLocation_ID` =  `EMAx_RoomLocation`.`ID`
		AND  `EMAx_Event`.`EMAx_Person_ID` =  `EMAx_Person`.`ID`
	";
	private $sqlBaseOrganization = "
		SELECT DISTINCT
		`EMAx_Organization`.`ID` ,
		`EMAx_Organization`.`name` ,
		`EMAx_Organization`.`address` ,
		`EMAx_Organization`.`emailAddress` ,
		`EMAx_Organization`.`phoneNumber`,
		`EMAx_Zip`.`name` as `Zip`,
		`EMAx_State`.`name` as `State`,
		`EMAx_City`.`name` as `City`
		FROM  `EMAx_Organization`
		JOIN  `EMAx_Zip` , `EMAx_State` , `EMAx_City` , `EMAx_Person`
		WHERE `EMAx_Organization`.`EMAx_State_ID` =  `EMAx_State`.`ID`
		AND  `EMAx_Organization`.`EMAx_Zip_ID` =  `EMAx_Zip`.`ID`
		AND  `EMAx_Organization`.`EMAx_City_ID` =  `EMAx_City`.`ID`
	";
	function __construct()
	{
		$this->connection = new PDO('mysql:host='. EMAxSTATIC::$db_host .';dbname=' . EMAxSTATIC::$db_name, EMAxSTATIC::$db_user, EMAxSTATIC::$db_password);
		$this->results = array(
			'Person' => array(),
			'Event' => array(),
			'Organization' => array()
		);
	}
	public function getDefaultView()
	{
		$sqlEvent = $this->sqlBaseEvent;
		$sqlEvent .= "AND `startTime` >= CURDATE() ORDER BY `startTime` LIMIT 10";
		$queryResult = $this->connection->query($sqlEvent);
		$queryArr = ($queryResult) ? $queryResult->fetchAll() : array();
		$Event = array();
		foreach($queryArr as $record)
		{
			$Event[] = $record;
		}
		return $Event;
	}
	public function getPersonSearch($id = NULL)
	{
		$id = ($id == '') ? NULL : (int)$id;
		$queryResult = $this->connection->query("SELECT * FROM `EMAx_Person` WHERE `ID`=". $this->connection->quote($id) );
		$queryArr = ($queryResult) ? $queryResult->fetchAll() : array();
		foreach($queryArr as $record)
		{
			$objectToGetForienKey = $record;
		}
		$sqlPerson = $this->sqlBasePerson . " AND `EMAx_Person`.`ID`=" . $this->connection->quote($id);
		$sqlEvent = $this->sqlBaseEvent . " AND `EMAx_Event`.`EMAx_Person_ID`=" . $this->connection->quote($id) ;
		$sqlOrganization = $this->sqlBaseOrganization . " AND `EMAx_Organization`.`ID`=" .
			$this->connection->quote($objectToGetForienKey['EMAx_Organization_ID'])
		;
		$Person = array();
		$Event = array();
		$Organization = array();
		$queryResult = $this->connection->query($sqlPerson);
		$queryArr = ($queryResult) ? $queryResult->fetchAll() : array();
		foreach($queryArr as $record)
		{
			$Person[] = $record;
		}
		$queryResult = $this->connection->query($sqlEvent);
		$queryArr = ($queryResult) ? $queryResult->fetchAll() : array();
		foreach($queryArr as $record)
		{
			$Event[] = $record;
		}
		$queryResult = $this->connection->query($sqlOrganization);
		$queryArr = ($queryResult) ? $queryResult->fetchAll() : array();
		foreach($queryArr as $record)
		{
			$Organization[] = $record;
		}
		$this->results['Person'] = $Person ;
		$this->results['Event'] = $Event ;
		$this->results['Organization'] = $Organization ;
		return $this->getCurrentResult();
	}
	public function getEventSearch($id = NULL)
	{
		$id = ($id == '') ? NULL : (int)$id;
		$queryResult = $this->connection->query("SELECT * FROM `EMAx_Event` WHERE `ID`=". $this->connection->quote($id) );
		$queryArr = ($queryResult) ? $queryResult->fetchAll() : array();
		foreach($queryArr as $record)
		{
			$objectToGetForienKey = $record;
		}
		$sqlPerson = $this->sqlBasePerson . " AND `EMAx_Person`.`ID` = ".
			$this->connection->quote($objectToGetForienKey['EMAx_Person_ID'])
		;
		$sqlEvent = $this->sqlBaseEvent . " AND `EMAx_Event`.`ID`=" . $this->connection->quote($id) ;
		$sqlOrganization = $this->sqlBaseOrganization . " AND `EMAx_Organization`.`ID` = ".
			$this->connection->quote($objectToGetForienKey['EMAx_Organization_ID'])
		;
		$Person = array();
		$Event = array();
		$Organization = array();
		$queryResult = $this->connection->query($sqlEvent);
		$queryArr = ($queryResult) ? $queryResult->fetchAll() : array();
		foreach($queryArr as $record)
		{
			$Event[] = $record;
		}
		$queryResult = $this->connection->query($sqlPerson);
		$queryArr = ($queryResult) ? $queryResult->fetchAll() : array();
		foreach($queryArr as $record)
		{
			$Person[] = $record;
		}
		$queryResult = $this->connection->query($sqlOrganization);
		$queryArr = ($queryResult) ? $queryResult->fetchAll() : array();
		foreach($queryArr as $record)
		{
			$Organization[] = $record;
		}
		$this->results['Person'] = $Person ;
		$this->results['Event'] = $Event ;
		$this->results['Organization'] = $Organization ;
		return $this->getCurrentResult();
	}
	public function getOrganizationSearch($id = NULL)
	{
		$id = ($id == '') ? NULL : (int)$id;
		$sqlPerson = $this->sqlBasePerson . " AND `EMAx_Person`.`EMAx_Organization_ID`=" . $this->connection->quote($id) ;
		$sqlEvent = $this->sqlBaseEvent . " AND `EMAx_Event`.`EMAx_Organization_ID`=" . $this->connection->quote($id) ;
		$sqlOrganization = $this->sqlBaseOrganization . " AND `EMAx_Organization`.`ID`=" . $this->connection->quote($id) ;
		$Person = array();
		$Event = array();
		$Organization = array();
		$queryResult = $this->connection->query($sqlOrganization);
		$queryArr = ($queryResult) ? $queryResult->fetchAll() : array();
		foreach($queryArr as $record)
		{
			$Organization[] = $record;
		}
		$queryResult = $this->connection->query($sqlPerson);
		$queryArr = ($queryResult) ? $queryResult->fetchAll() : array();
		foreach($queryArr as $record)
		{
			$Person[] = $record;
		}
		$queryResult = $this->connection->query($sqlEvent);
		$queryArr = ($queryResult) ? $queryResult->fetchAll() : array();
		foreach($queryArr as $record)
		{
			$Event[] = $record;
		}
		$this->results['Person'] = $Person ;
		$this->results['Event'] = $Event ;
		$this->results['Organization'] = $Organization ;
		return $this->getCurrentResult();
	}
	public function getCurrentResult()
	{
		return $this->results;
	}
	public function doSearchString($searchString)
	{
		$sqlPerson = $this->sqlBasePerson;
		$sqlEvent = $this->sqlBaseEvent;
		$sqlOrganization = $this->sqlBaseOrganization;
		date_default_timezone_set($CONFIG->TIMEZONE);
		if(strtotime($searchString))
		{
			$date = date('Y-m-d', strtotime($searchString));
			$sqlEvent .= "
				AND DATE(`EMAx_Event`.`startTime`) = ". $this->connection->quote($date) ."
				ORDER BY `EMAx_Event`.`startTime` DESC
			";
			$sqlOrganization = "";
			$sqlPerson = "";
		}
		else
		{
			$searchStringArray = explode( ' ' , $searchString );
			foreach($searchStringArray as $search)
			{
				$search = $this->connection->quote( '%' . $search . '%' );
				$sqlPerson .= "
				AND (
					`EMAx_Person`.`fName` LIKE " . $search . " OR
					`EMAx_Person`.`mName` LIKE " . $search . " OR
					`EMAx_Person`.`lName` LIKE " . $search . " OR
					`EMAx_Person`.`address` LIKE " . $search . " OR
					`EMAx_Person`.`emailAddress` LIKE " . $search . " OR
					`EMAx_Person`.`secondaryPhoneNumber` LIKE " . $search . " OR
					`EMAx_Person`.`phoneNumber` LIKE " . $search . " OR
					`EMAx_Organization`.`name` LIKE " . $search . " OR
					`EMAx_Zip`.`name` LIKE " . $search . " OR
					`EMAx_State`.`name` LIKE " . $search . " OR
					`EMAx_City`.`name` LIKE " . $search . "
				)
				";
				$sqlEvent .= "
				AND (
					`EMAx_Login`.`userName` LIKE " . $search . " OR
					`EMAx_RoomLocation`.`name` LIKE " . $search . " OR
					`EMAx_Organization`.`name` LIKE " . $search . " OR
					`EMAx_Person`.`fName` LIKE " . $search . " OR
					`EMAx_Person`.`mName` LIKE " . $search . " OR
					`EMAx_Person`.`lName` LIKE " . $search . " OR
					`EMAx_Person`.`phoneNumber` LIKE " . $search . " OR
					`EMAx_Person`.`emailAddress` LIKE " . $search . "
				)
				";
				$sqlOrganization .= "
				AND (
					`EMAx_Organization`.`name` LIKE " . $search . " OR
					`EMAx_Organization`.`address` LIKE " . $search . " OR
					`EMAx_Organization`.`emailAddress` LIKE " . $search . " OR
					`EMAx_Organization`.`phoneNumber` LIKE " . $search . " OR
					`EMAx_Zip`.`name` LIKE " . $search . " OR
					`EMAx_State`.`name` LIKE " . $search . " OR
					`EMAx_City`.`name` LIKE " . $search . "
				)
				";
			}
			$sqlEvent .= " ORDER BY  `EMAx_Event`.`startTime` DESC ";
		}
		$Person = array();
		$Event = array();
		$Organization = array();
		$queryResult = $this->connection->query($sqlOrganization);
		$queryArr = ($queryResult) ? $queryResult->fetchAll() : array();
		foreach($queryArr as $record)
		{
			$Organization[] = $record;
		}
		$queryResult = $this->connection->query($sqlPerson);
error_log($sqlPerson . "\n is the sql person search string");		
		$queryArr = ($queryResult) ? $queryResult->fetchAll() : array();
		foreach($queryArr as $record)
		{
			$Person[] = $record;
		}
		$queryResult = $this->connection->query($sqlEvent);
		$queryArr = ($queryResult) ? $queryResult->fetchAll() : array();
		foreach($queryArr as $record)
		{
			$Event[] = $record;
		}
		$this->results['Person'] = $Person ;
		$this->results['Event'] = $Event ;
		$this->results['Organization'] = $Organization ;
		return $this->getCurrentResult();
	}
}
?>
