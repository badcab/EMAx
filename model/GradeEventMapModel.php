<?php
//this file shold be deleted
require_once('../configure/EMAxSTATIC.php');
require_once('EventModel.php');
require_once('GradeModel.php');
class GradeEventMapModel
{
	private $ClassObjectArg;
	private $EventID;
	
	function __construct(EventModel $EventModelObject = NULL)
	{
		 
		$this->$EventID = $EventModelObject->getID();
		$connection = new PDO('mysql:host='. EMAxSTATIC::$db_host .';dbname=' . EMAxSTATIC::$db_name, EMAxSTATIC::$db_user, EMAxSTATIC::$db_password);
		$result = $connection->query("SELECT * FROM `EMAx_GradeEventMap` WHERE `EMAx_Event_ID`='" . $EventModelObject->getID() . "'");
		$GradeList = $result->fetchAll();
		$this->ClassObjectArg = array();
		
		foreach($GradeList as $list)	
		{
			$this->ClassObjectArg[] = $list['EMAx_Grade_ID'];
		}
		$connection = NULL;
	}
	
	public function getGrade()
	{
		$GradeName = array();
		foreach($ClassObjectArg as $GradeID)
		{
			$GradeName[] = $GradeID['name'];	
		}
		return $GradeName;
	}
	
	public function setGrade(array $arrOfGradeNames)//must be an array should also write to do 
	{
		//each element of the array should be a grade name
		//use grade name to ID
		//delete all options associated with event
		//write all things in this new array with the EventID
	}
	
	
}
 
?>