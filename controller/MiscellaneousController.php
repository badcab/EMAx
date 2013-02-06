<?php 
class MiscellaneousController
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

		require_once('../model/RoomLocationModel.php');
		require_once('../model/StateModel.php');
		require_once('../model/GradeModel.php');
		require_once('../model/OptionModel.php');

		$RoomLocation = new RoomLocationModel();
		$State = new StateModel();
		$Grade = new GradeModel();
		$Option = new OptionModel();

		$stateList = $State->getList();
		$roomList = $RoomLocation->getList();
		$gradeList = $Grade->getList();
		$optionList = $Option->getList();
		$costRoom = $this->costDropdown('roomCost');
		$costOption = $this->costDropdown('optionCost');
		$costGrade = $this->costDropdown('gradeCost');
		
		sort($stateList);
		
		require_once('../view/MiscellaneousView.php');
	}
	
	private function costDropdown($id, $maxMoney = 5.00, $incrementBy = 0.25, $superMaxMoney = 100.01)
	{
		setlocale(LC_MONETARY, 'en_US');

		$result = "<select id='{$id}' name='{$id}' onchange=''>";
		for($i = 0.00; $i < $maxMoney; $i += $incrementBy) 
		{
			$result .= "<option value='{$i}'>" . money_format('%(#10n', $i) . "</option>";
		}	
		for($i = $maxMoney; $i < $superMaxMoney; $i += $maxMoney) 
		{
			$result .= "<option value='{$i}'>" . money_format('%(#10n', $i) . "</option>";
		}	
		$result .= "</select>";
		$result .= "<input type='hidden' value='' id='{$id}hidden' />";
		return $result;
	}
}
?>