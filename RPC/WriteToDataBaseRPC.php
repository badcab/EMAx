<?php  
$formData = (isset($_POST['formData'])) ? $_POST['formData'] : NULL;
parse_str($formData, $writeToDB);
error_log($formData);
switch($writeToDB['table'])
{
	case "Person" :
		require_once('../module/WritePersonModule.php');
		$WritePerson = new WritePersonModule();
		$WritePerson->activate($writeToDB);
		break;	
	
	case "Event" :
		require_once('../module/WriteEventModule.php');
		$WriteEvent = new WriteEventModule();
		$WriteEvent->activate($writeToDB);
		break;
	
	case "Organization" :
		require_once('../module/WriteOrganizationModule.php');
		$WriteOrganization = new WriteOrganizationModule();
		$WriteOrganization->activate($writeToDB);
		break;
}

?>