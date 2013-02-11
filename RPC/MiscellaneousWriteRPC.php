<?php
$tableName = $_POST['tableName'];
$Action = $_POST['Action'];
$stringValue = trim($_POST['stringValue']);
$costValue1 = (isset($_POST['cost1'])) ? $_POST['cost1'] : NULL;
$costValue2 = (isset($_POST['cost2'])) ? $_POST['cost2'] : NULL;
$costValue3 = (isset($_POST['cost3'])) ? $_POST['cost3'] : NULL;
$costValue4 = (isset($_POST['cost4'])) ? $_POST['cost4'] : NULL;
if($Action == "ADD")
{
	if($stringValue == '') return;
	switch($tableName) 
	{
		case "GRADE":
			require_once('../model/GradeModel.php');
				if($costValue1)
				{
					$Grade = new GradeModel($stringValue, $costValue1);
				}			
				
				else
				{
					$Grade = new GradeModel($stringValue);
				}
		break;
		
		case "OPTION":
			require_once('../model/OptionModel.php');
				if($costValue1)
				{
					$Option = new OptionModel($stringValue, $costValue1);
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
				if($costValue1)
				{
					$Room = new RoomLocationModel($stringValue, $costValue1, $costValue2, $costValue3, $costValue4);
				}			
				
				else
				{
					$Room = new RoomLocationModel($stringValue);
				}					
		break;
	}
}

if($Action == "DELETE")
{
	switch($tableName) 
	{
		case "GRADE":
			require_once('../model/GradeModel.php');
			$Grade = new GradeModel($stringValue);
			$Grade->setCost(0.00);
			$Grade->writeChanges();				
			$UpdateCost = new _UpdateCostModule();
			$UpdateCost->fkGrade($Grade->getID());
			$Grade->deleteRecord();
		break;
		
		case "OPTION":
			require_once('../model/OptionModel.php');
			$Option = new OptionModel($stringValue);

			$Option->setCost(0.00);
			$Option->writeChanges();				
			$UpdateCost = new _UpdateCostModule();
			$UpdateCost->fkOption($Option->getID());
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
?>