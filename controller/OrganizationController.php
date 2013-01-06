<?php 
require_once('../model/OrganizationModel.php');
require_once('../configure/EMAxSTATIC.php');
class OrganizationController
{
	function __construct()
	{
		if(!isset($_SESSION)) 
		{ 
			session_start();
		} 
	}
	
	public function activate($id = NULL)
	{
		if(!$_SESSION['isLoggedIn'])
		{
			require_once('../view/LoginView.php');
			return;
		}

		$Organization = new OrganizationModel((int)$id);
		$City = $Organization->getCity();
		$State = $Organization->getState();
		$Zip = $Organization->getZip();
		$orgList = $Organization->getList();
		$stateList = $State->getList();
		$stateDropDown = '';
		foreach($stateList as $state)
		{			
			if($state['name'] == EMAxSTATIC::$DEFAULT_STATE) 
			{
				$stateDropDown .= "<option selected='selected' value='{$state['id']}'> {$state['name']} </option>";
			}
			else
			{
				$stateDropDown .= "<option value='{$state['id']}'>{$state['name']}</option>";
			}
			
		}	
		
		$county = EMAxSTATIC::$COUNTY;
		
		require_once('../view/OrganizationView.php');
	}
}
?>