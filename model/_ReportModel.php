<?php
require_once('../configure/EMAxSTATIC.php');
class _ReportModel
{
	function __construct()
	{
		/*does nothing*/
	}
	public function attendanceReport($start, $end)
	{
		$result = array(
			'Total_Kids_Field_Trip' => 0,
			'Total_income_Field_Trip' => 0,
			'Total_Room_Reservations' => 0,
			'Total_income_Room_Reservations' => 0,
		);
		date_default_timezone_set($CONFIG->TIMEZONE);
		$startDate = date('Y-m-d', strtotime($start));
		$endDate = date('Y-m-d', strtotime($end));
		if(!$startDate || !$endDate)
		{
			return $result;
		}
		if($startDate > $endDate)
		{
			$temp = $startDate;
			$startDate = $endDate;
			$endDate = $temp;
		}
		$formatedStartDate = $this->make_Time( 0 , $startDate );
		$formatedEndDate = $this->make_Time( (60 * 60 * 24) - 1 , $endDate );
		$connection = new PDO('mysql:host='. EMAxSTATIC::$db_host .';dbname=' . EMAxSTATIC::$db_name, EMAxSTATIC::$db_user, EMAxSTATIC::$db_password);
		date_default_timezone_set($CONFIG->TIMEZONE);
		$feildTrip = EMAxSTATIC::$FIELD_TRIP_EVENT;
		$notProfit = EMAxSTATIC::$ROOM_RESERVATION_NON_PROFIT;
		$forProfit = EMAxSTATIC::$ROOM_RESERVATION_FOR_PROFIT;
		$publicProgram = EMAxSTATIC::$PUBLIC_PROGRAM_EVENT;
		$sqlKidAttend = "SELECT SUM(attendance),  SUM(cost) FROM `EMAx_Event` WHERE `startTime` > '{$formatedStartDate}' AND `endTime` < '{$formatedEndDate}' AND `roomReservation` = {$feildTrip}";
		$sqlRoomReservation = "SELECT COUNT(*), SUM(cost) FROM `EMAx_Event` WHERE `startTime` > '{$formatedStartDate}' AND `endTime` < '{$formatedEndDate}' AND `roomReservation` = {$notProfit} OR `roomReservation` = {$forProfit}";

		$sqlPublicProgram = "SELECT SUM(revenue), SUM(expenses), `EMAx_Event`.SUM(attendance) FROM `EMAx_PublicProgramMoney` JOIN `EMAx_Event`
		WHERE `EMAx_PublicProgramMoney`.`EMAx_Event_ID` = `EMAx_Event`.`ID`
		AND `startTime` > '{$formatedStartDate}' AND `endTime` < '{$formatedEndDate}'
		AND `roomReservation` = {$publicProgram} ";


		$sqlKidAttendQuery = $connection->query($sqlKidAttend);
		$sqlRoomReservationQuery = $connection->query($sqlRoomReservation);
		$KidAttendResult = ($sqlKidAttendQuery) ? $sqlKidAttendQuery->fetch(PDO::FETCH_ASSOC): NULL;
		$RoomResResult = ($sqlRoomReservationQuery) ? $sqlRoomReservationQuery->fetch(PDO::FETCH_ASSOC): NULL;
		$result['Total_Kids_Field_Trip'] = ($KidAttendResult['SUM(attendance)']) ? $KidAttendResult['SUM(attendance)']: 0;
		$result['Total_income_Field_Trip'] = ($KidAttendResult['SUM(cost)']) ? $KidAttendResult['SUM(cost)']: 0.00;
		$result['Total_Room_Reservations'] = ($RoomResResult['COUNT(*)']) ? $RoomResResult['COUNT(*)'] : 0;
		$result['Total_income_Room_Reservations'] = ($RoomResResult['SUM(cost)']) ? $RoomResResult['SUM(cost)'] : 0.00;
		$result['Total_revenue_public_program'] = ($sqlPublicProgram['SUM(revenue)']) ? $sqlPublicProgram['SUM(revenue)'] : 0.00;
		$result['Total_expenses_public_program'] = ($sqlPublicProgram['SUM(expenses)']) ? $sqlPublicProgram['SUM(expenses)'] : 0.00;
		$result['Total_attendance_public_program'] = ($sqlPublicProgram['SUM(attendance)']) ? $sqlPublicProgram['SUM(attendance)'] : 0;
		$connection = NULL;
		return $result;
	}
	public function optionReport($start, $end, $filter, $filterID)
	{
		$result = NULL;
		$connection = new PDO('mysql:host='. EMAxSTATIC::$db_host .';dbname=' . EMAxSTATIC::$db_name, EMAxSTATIC::$db_user, EMAxSTATIC::$db_password);
		date_default_timezone_set($CONFIG->TIMEZONE);
		$filterTable = ($filter == 'Option') ? 'EMAx_OptionEventMap`.`EMAx_Option_ID' : 'EMAx_RoomLocation_ID' ;
		$join = '`EMAx_Organization` , `EMAx_Person`';
		$join .= ($filter == 'Option') ? ', `EMAx_OptionEventMap`' : '' ;
		$andOption = ($filter == 'Option') ? 'AND `EMAx_OptionEventMap`.`EMAx_Event_ID` = `EMAx_Event`.`ID`' : ''; 
		$filterID = (int)$filterID;
		$startDate = date('Y-m-d', strtotime($start));
		$endDate = date('Y-m-d', strtotime($end));
		if(!$startDate || !$endDate)
		{
			return $result;
		}
		if($startDate > $endDate)
		{
			$temp = $startDate;
			$startDate = $endDate;
			$endDate = $temp;
		}
		$formatedStartDate = $this->make_Time( 0 , $startDate );
		$formatedEndDate = $this->make_Time( (60 * 60 * 24) - 1 , $endDate );
		$sql = "SELECT
			`EMAx_Event`.`ID`,
			`EMAx_Event`.`startTime`,
			`EMAx_Event`.`endTime`,
			`EMAx_Organization`.`name`,
			`EMAx_Person`.`phoneNumber`,
			`EMAx_Person`.`emailAddress`,
			`EMAx_Person`.`fName`,
			`EMAx_Person`.`lName`
		FROM `EMAx_Event`
		JOIN  {$join}
		WHERE `EMAx_Person`.`ID` = `EMAx_Event`.`EMAx_Person_ID`
		{$andOption}
		AND `EMAx_Organization`.`ID` = `EMAx_Event`.`EMAx_Organization_ID`
		AND `EMAx_Event`.`startTime` > '{$formatedStartDate}'
		AND `EMAx_Event`.`endTime` < '{$formatedEndDate}'
		AND `{$filterTable}` = '{$filterID}'
		ORDER BY `EMAx_Event`.`startTime` ASC";
error_log($sql . ' line 101 _ReportModel');
		$result = array();
		$queryResult = $connection->query($sql);
		$queryArr = ($queryResult) ? $queryResult->fetchAll() : array();
		foreach($queryArr as $record)
		{
			$result[] = $record;
		}
		$connection = NULL;
		return $result;
	}
	public function dateRangeReport($start, $end)
	{
		$result = NULL;
		$connection = new PDO('mysql:host='. EMAxSTATIC::$db_host .';dbname=' . EMAxSTATIC::$db_name, EMAxSTATIC::$db_user, EMAxSTATIC::$db_password);
		date_default_timezone_set($CONFIG->TIMEZONE);
		$startDate = date('Y-m-d', strtotime($start));
		$endDate = date('Y-m-d', strtotime($end));
		if(!$startDate || !$endDate)
		{
			return $result;
		}
		if($startDate > $endDate)
		{
			$temp = $startDate;
			$startDate = $endDate;
			$endDate = $temp;
		}
		$formatedStartDate = $this->make_Time( 0 , $startDate );
		$formatedEndDate = $this->make_Time( (60 * 60 * 24) - 1 , $endDate );
		$sql = "SELECT
			`EMAx_Event`.`ID`,
			`EMAx_Event`.`startTime`,
			`EMAx_Event`.`endTime`,
			`EMAx_Organization`.`name`,
			`EMAx_Person`.`phoneNumber`,
			`EMAx_Person`.`emailAddress`,
			`EMAx_Person`.`fName`,
			`EMAx_Person`.`lName`
		FROM `EMAx_Event`
		JOIN  `EMAx_Organization` , `EMAx_Person`
		WHERE `EMAx_Person`.`ID` = `EMAx_Event`.`EMAx_Person_ID`
		AND `EMAx_Organization`.`ID` = `EMAx_Event`.`EMAx_Organization_ID`
		AND `EMAx_Event`.`startTime` > '{$formatedStartDate}'
		AND `EMAx_Event`.`endTime` < '{$formatedEndDate}'
		ORDER BY `EMAx_Event`.`startTime` ASC";
		$result = array();
		$queryResult = $connection->query($sql);
		$queryArr = ($queryResult) ? $queryResult->fetchAll() : array();
		foreach($queryArr as $record)
		{
			$result[] = $record;
		}
		$connection = NULL;
		return $result;
	}
	private function make_Time($time, $day)
	{
		date_default_timezone_set($CONFIG->TIMEZONE);
		$timets = date("H:i:s", $time);
		$dayts = date('Y-m-d', strtotime($day));
		return $dayts . ' ' . $timets;
	}
}
?>
