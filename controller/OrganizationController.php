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
		global $CONFIG;
		$areaCode = $CONFIG->AREA_CODE;
		$Organization = new OrganizationModel((int)$id);
		$City = $Organization->getCity();
		$State = $Organization->getState();
		$Zip = $Organization->getZip();
		$orgList = $Organization->getList();
		$stateList = $State->getList();
		$sameCounty = ($Organization->getsameCounty()) ? 1 : 0;
		$stateDropDown = '';
		foreach($stateList as $state)
		{
			if($state['name'] == $CONFIG->DEFAULT_STATE)
			{
				$stateDropDown .= "<option selected='selected' value='{$state['id']}'> {$state['name']} </option>";
			}
			else
			{
				$stateDropDown .= "<option value='{$state['id']}'>{$state['name']}</option>";
			}
		}
		$county = $CONFIG->COUNTY;
		require_once('../view/OrganizationView.php');
	}
}
?>
