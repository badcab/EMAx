<?php
//require_once('../module/_UpdateCostModule.php');
//require_once('../configure/EMAxSTATIC.php');
$tableName = $_POST['tableName'];
$Action = $_POST['Action'];
$stringValue = trim($_POST['stringValue']);
$costValue = (isset($_POST['cost'])) ? $_POST['cost'] : NULL;
if($Action == "ADD")
{
	if($stringValue == '') return;
	switch($tableName) 
	{
		case "GRADE":
			require_once('../model/GradeModel.php');
//			$Grade = new GradeModel($stringValue);
				if($costValue)
				{
					$Grade = new GradeModel($stringValue, $costValue);
				}			
				
				else
				{
					$Grade = new GradeModel($stringValue);
				}
		break;
		
		case "OPTION":
			require_once('../model/OptionModel.php');
//			$Option = new OptionModel($stringValue);
				if($costValue)
				{
					$Option = new OptionModel($stringValue, $costValue);
				}			
				
				else
				{
					$Option = new OptionModel($stringValue);
				}
		break;
		
		case "STATE":
			require_once('../model/StateModel.php');		
			$State = new StateModel($stringValue);
		break;
		
		case "ROOM":
			require_once('../model/RoomLocationModel.php');
//			$Room = new RoomLocationModel($stringValue);
				if($costValue)
				{
					$Room = new RoomLocationModel($stringValue, $costValue);
				}			
				
				else
				{
					$Room = new RoomLocationModel($stringValue);
				}					
		break;
	}
}

if($Action == "DELETE")//here is where we need to add the hooks to the module
{
	switch($tableName) 
	{
		case "GRADE":
			require_once('../model/GradeModel.php');
			$Grade = new GradeModel($stringValue);
			/*
			$Grade->setCost(0.00);
			$Grade->writeChanges();				
			$UpdateCost = new _UpdateCostModule();
			$UpdateCost->fkGrade($Grade->getID());
			*/
			$Grade->deleteRecord();
		break;
		
		case "OPTION":
			require_once('../model/OptionModel.php');
			$Option = new OptionModel($stringValue);
			/*
			$Option->setCost(0.00);
			$Option->writeChanges();				
			$UpdateCost = new _UpdateCostModule();
			$UpdateCost->fkOption($Option->getID());
			*/
			$Option->deleteRecord();
		break;
		
		case "STATE":
			require_once('../model/StateModel.php');
			$State = new StateModel($stringValue);
			$State->deleteRecord();
		break;
		
		case "ROOM":
			require_once('../model/RoomLocationModel.php');
			$Room = new RoomLocationModel($stringValue);
			$Room->deleteRecord();
		break;
	}	
}
?>$