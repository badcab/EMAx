<?php
require_once('../model/EventModel.php');
require_once('../configure/EMAxSTATIC.php');
class EventController
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
		if(!$_SESSION['isLoggedIn'])//maybe change this to $_SESSION['user']
		{
			require_once('../view/LoginView.php');
			return;
		}
		$Event = new EventModel($id);
		$Organization = $Event->getOrganization();
		$Person = $Event->getPerson();
		$person_phoneNumber = $Person->getphoneNumber();
		$person_phoneNumberAlt = $Person->getsecondaryPhoneNumber();
		$person_email = $Person->getemailAddress();
		$Login = $Event->getLogin();
error_log( $_SESSION['user'] . " is the logged in user");
$_SESSION['user'] = ($_SESSION['user']) ? $_SESSION['user'] : 'UNDEFINED USER ERROR';		
		$LoginUser = ($Login->getuserName()) ? $Login->getuserName() : $_SESSION['user'] ;
		$RoomLocation = $Event->getRoomLocation();
		$orgList = $Organization->getList();
		$roomList = $RoomLocation->getList();
		$prepay = ($Event->gethasPaid()) ? 1 : 0;
		$lunch = ($Event->gethavingLunch()) ? 1 : 0;
		$roomRes = ($Event->getroomReservation()) ? $Event->getroomReservation() : EMAxSTATIC::$FEILD_TRIP_EVENT;
		$selectedOptions = implode(',', $Event->getOption());
		$selectedGrades = implode(',', $Event->getGrade());
		date_default_timezone_set(EMAxSTATIC::$TIMEZONE);
		$date = '';
		if($id)
		{
			$startTime = strtotime(date('g:i a', strtotime($Event->getstartTime())));
			$endTime = strtotime(date('g:i a', strtotime($Event->getendTime())));
			$date = date('m/d/Y' , strtotime($Event->getstartTime()));
		}
		$attend = array();
		for($i = 0 ; $i < 100 ; $i++)
		{
			$attend[] = $i;
		}
		$timeOfEvent = array();
		for ($i = strtotime('9:00am') ; $i < strtotime('5:00pm') ; $i += 900)
		{
			$timeOfEvent[$i] = date('g:i a', $i);
		}
		require_once('../view/EventView.php');
	}
}
?>
