<?php
require_once('../model/PersonModel.php');
class PersonController
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
		$areaCode = EMAxSTATIC::$AREA_CODE;
		$Person = new PersonModel($id);
		$State = $Person->getState();
		$Organization = $Person->getOrganization();
		$City = $Person->getCity();
		$orgList = $Organization->getList();
		$stateList = $State->getList();
		$cityList = $City->getList();
		$Zip = $Person->getZip();
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
		require_once('../view/PersonView.php');
	}
}
?>
