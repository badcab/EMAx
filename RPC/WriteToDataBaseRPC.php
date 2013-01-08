<?php  
$formData = (isset($_POST['formData'])) ? $_POST['formData'] : NULL;
parse_str($formData, $writeToDB);
error_log($formData);
$id = NULL;
switch($writeToDB['table'])
{
	case "Person" :
		require_once('../module/WritePersonModule.php');
		$WritePerson = new WritePersonModule();
		$id = $WritePerson->activate($writeToDB);
		break;	
	
	case "Event" :
		require_once('../module/WriteEventModule.php');
		$WriteEvent = new WriteEventModule();
		$id = $WriteEvent->activate($writeToDB);
		break;
	
	case "Organization" :
		require_once('../module/WriteOrganizationModule.php');
		$WriteOrganization = new WriteOrganizationModule();
		$id = $WriteOrganization->activate($writeToDB);
		break;
}
error_log($id . ' in the write to db rpc');
echo($id);//will echo the id of the item just created or updated
?>