<?php
class SearchModule
{
	private $connection;
	private $results;
	
	private $sqlBasePerson = "
		SELECT DISTINCT
		`EMAx_Person`.`fName`, 
		`EMAx_Person`.`mName` , 
		`EMAx_Person`.`lName` , 
		FROM  `EMAx_Person` 
	";
	
	
	private $sqlBaseOrganization = "
		SELECT DISTINCT
		`EMAx_Organization`.`name` ,
		FROM  `EMAx_Organization` 
	";

	function __construct()
	{
		require('../configure/db_connect.php');
		$this->connection = new PDO('mysql:host='. $db_host .';dbname=' . $db_name, $db_user, $db_password);

		$this->results = array(
			'Person' => array(),		
			'Organization' => array()
		);		
	}

	public function activate()
	{
		$Person = array();
		$Event = array();
		$Organization = array();
		
		$queryResult = $this->connection->query($this->sqlBasePerson);
		$queryArr = ($queryResult) ? $queryResult->fetchAll() : array();
		foreach($queryArr as $record)	
		{
			$Person[] = implode(' ', $record);
		}
		
		$queryResult = $this->connection->query($this->sqlBaseOrganization);
		$queryArr = ($queryResult) ? $queryResult->fetchAll() : array();
		foreach($queryArr as $record)	
		{
			$Organization[] = implode(' ', $record);
		}
		
		return implode(',', $Person) . ',' . implode(',', $Organization); 
	}
}
?>