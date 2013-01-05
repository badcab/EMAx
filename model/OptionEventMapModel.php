<?php
require_once('EventModel.php');
require_once('OptionModel.php');
class OptionEventMapModel
{
	private $ClassObjectArg;
	private $EventID;
	
	function __construct(EventModel $EventModelObject = NULL)
	{
		require('../configure/db_connect.php'); 
		$this->$EventID = $EventModelObject->getID();
		$connection = new PDO('mysql:host='. $db_host .';dbname=' . $db_name, $db_user, $db_password);
		$result = $connection->query("SELECT * FROM `EMAx_OptionEventMap` WHERE `EMAx_Event_ID`='" . $EventModelObject->getID() . "'");
		$OptionList = $result->fetchAll();
		$this->ClassObjectArg = array();
		
		foreach($OptionList as $list)	
		{
			$this->ClassObjectArg[] = $list['EMAx_Option_ID'];
		}
		$connection = NULL;
	}
	
	public function getOption()
	{
		$OptionName = array();
		foreach($ClassObjectArg as $OptionID)
		{
			$OptionName[] = $OptionID['name'];	
		}
		return $OptionName;
	}
	
	public function setOption(array $arrOfOptionNames)//must be an array should also write to do 
	{
		//each element of the array should be a Option name
		//use Option name to ID
		//delete all options associated with event
		//write all things in this new array with the EventID
	}
}
?>