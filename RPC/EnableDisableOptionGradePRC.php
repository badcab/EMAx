<?php

$tableName = (isset($_POST['tableName'])) ? $_POST['tableName'] : NULL;
$selectionName = (isset($_POST['selectionName'])) ? $_POST['selectionName'] : NULL;
$setValueTo = (isset($_POST['setValueTo'])) ? $_POST['setValueTo'] : NULL;

error_log("EnableDisableOptionGradeRPC line7 \n TableName: " . $tableName . "\n SelectionName: " . $selectionName . "\n SetValueTo: " . $setValueTo);

if($tableName == 'GRADE')
{
	require_once('../model/GradeModel.php');
	$Grade = new GradeModel($selectionName);
	$Grade->setEnable((int)$setValueTo);
	$Grade->writeChanges();
	$result = ($Grade->getEnable()) ? 'Disable' : 'Enable' ;
	echo($result);
}

if($tableName == 'OPTION')
{
	require_once('../model/OptionModel.php');
	$Option = new OptionModel($selectionName);
	$Option->setEnable((int)$setValueTo);
	$Option->writeChanges();
	$result = ($Grade->getEnable()) ? 'Disable' : 'Enable' ;
	echo($result);
}


if($tableName == 'ROOM')
{
	require_once('../model/RoomLocationModel.php');
	$Room = new RoomLocationModel($selectionName);
	$Room->setEnable((int)$setValueTo);
	$Room->writeChanges();
	$result = ($Room->getEnable()) ? 'Disable' : 'Enable' ;
	echo($result);
}
?>