<?php
require_once('../configure/EMAxSTATIC.php');
class WriteEventModule
{
	function __construct()
	{
		if(!isset($_SESSION)) 
		{ 
			session_start();
		} 	
	}

	public function activate($dataArray)
	{
		require_once('../model/EventModel.php');
		require_once('../model/OrganizationModel.php');
		require_once('../model/PersonModel.php');
		require_once('../model/RoomLocationModel.php');
		require_once('../model/LoginModel.php');
		require_once('_CostModule.php');
		
		$Event = new EventModel((int)$dataArray['id']);
		$Organization = new OrganizationModel((int)$dataArray['Organization']);
		$Person = new PersonModel((int)$dataArray['dropDownPerson']);
		$RoomLocation = new RoomLocationModel((int)$dataArray['RoomLocation']);
		$Login = new LoginModel($_SESSION['user']);
		
		$Event->setattendance($dataArray['attendance']);
		$Event->sethavingLunch($dataArray['Lunch']);
		$Event->sethasPaid($dataArray['Paid']);
		$Event->setroomReservation($dataArray['roomReservation']);
		$Event->setnotes($dataArray['notes']);
		
		$Event->setstartTime($this->make_Time($dataArray['startTime'], $dataArray['Date']));
		$Event->setendTime($this->make_Time($dataArray['endTime'], $dataArray['Date']));
		$Event->setGrade($dataArray['gradeEventMapHiddenText']);
		$Event->setOption($dataArray['optionEventMapHiddenText']);

		$Event->setOrganization($Organization);
		$Event->setPerson($Person);
		$Event->setRoomLocation($RoomLocation);
		$Event->setLogin($Login);
		
		$Event->writeData();
		$eventID = $Event->getID();
		
		if(
			$Event->getroomReservation() == EMAxSTATIC::$FEILD_TRIP_EVENT ||
			$Event->getroomReservation() == EMAxSTATIC::$ROOM_RESERVATION_NON_PROFIT ||
			$Event->getroomReservation() == EMAxSTATIC::$ROOM_RESERVATION_FOR_PROFIT		
		)
		{
			$CostModule = new _CostModule();
			$cost = $CostModule->singleEventCost($eventID);
			$CostModule->writeCost($cost, $eventID);
		}
		
		if($Event->getroomReservation() == EMAxSTATIC::$PUBLIC_PROGRAM_EVENT)
		{
			$PublicProgramMoneyModule = new PublicProgramMoneyModule();
			$PublicProgramMoneyModule->activate($Event, $expence, $reventue)
		}		
				
		return $eventID;
	}
	
	private function make_Time($time, $day)
	{
		date_default_timezone_set(EMAxSTATIC::$TIMEZONE);
		$timets = date("H:i:s", $time);
		$dayts = date('Y-m-d', strtotime($day));

		return $dayts . ' ' . $timets;
	}
}
?>
