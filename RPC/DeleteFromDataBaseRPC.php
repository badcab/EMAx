<?php
$formData = (isset($_POST['formData'])) ? $_POST['formData'] : NULL;
parse_str($formData, $writeToDB);
$id = (int)$writeToDB['id'];
if($id)
{
	switch($writeToDB['table'])
	{
		case "Person" :
			require_once('../module/DeletePersonModule.php');
			$DeletePerson = new DeletePersonModule($id);
			unset($DeletePerson);
			break;	
		
		case "Event" :
			require_once('../module/DeleteEventModule.php');
			$DeleteEvent = new DeleteEventModule($id);
			unset($DeleteEvent);
			break;
		
		case "Organization" :
			require_once('../module/DeleteOrganizationModule.php');
			$DeleteOrganization = new DeleteOrganizationModule($id);
			unset($DeleteOrganization);
			break;
	}	
}

?>