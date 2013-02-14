<?php
require_once('../model/EventModel.php');
require_once('../configure/EMAxSTATIC.php');
class _CostModule
{
	public function writeCost($cost, $eventID)
	{
		$cost = (double)$cost;
		$eventID = (int)$eventID;		
		$connection = new PDO('mysql:host='. EMAxSTATIC::$db_host .';dbname=' . EMAxSTATIC::$db_name, EMAxSTATIC::$db_user, EMAxSTATIC::$db_password);			
		$sql = "UPDATE `EMAx_Event` SET `cost`= " . $connection->quote($cost) . " WHERE `ID` = " . $connection->quote($eventID);
		$connection->exec($sql);	
	}
	public function singleEventCost($eventID)
	{
		global $CONFIG;
		$Event = new EventModel((int)$eventID);
		$Room = $Event->getRoomLocation();
		$sum = 0.00;
		$gradeCost = 0.00;
		$optionCost = 0.00;
		$baseCost = 0.00;
		$minimumCharge = (double)$CONFIG->MINIMUM_FIELD_TRIP_INCOME;
		$lengthOfTime = $this->lengthOfTime($Event->getstartTime(), $Event->getendTime());
		$lengthOfTimeHourCutOff = $CONFIG->HOURS_BEFORE_EXTRA_CHARGE;
		$longCharge = ( $lengthOfTime > $lengthOfTimeHourCutOff) ? TRUE : FALSE ;
		$surchargeForOutOfCounty = (double)$CONFIG->SURCHARGE_FOR_OUT_OF_COUNTY;
		$optionCost = $this->getOptionTotal($Event->getOption());
		$gradeCost = $this->getGradeTotal($Event->getGrade());
		$OrgInCounty = $Event->getOrganization()->getsameCounty();
		
		if( $Event->getroomReservation() == EMAxSTATIC::$FEILD_TRIP_EVENT )
		{
			$sum = $gradeCost + $optionCost;//not done yet
			if($OrgInCounty)
			{
				$sum += $surchargeForOutOfCounty;	
			}
			$sum = ($sum < $minimumCharge) ? $minimumCharge : $sum ;
		}
		
		if( $Event->getroomReservation() == EMAxSTATIC::$ROOM_RESERVATION_NON_PROFIT )
		{
			$roomCost = ($longCharge) ? $Room->getCostExtraLongNonProfit() : $Room->getCostBaseNonProfit() ;
			$sum = $roomCost + $optionCost;
		}
		
		if( $Event->getroomReservation() == EMAxSTATIC::$ROOM_RESERVATION_FOR_PROFIT )
		{
			$roomCost = ($longCharge) ? $Room->getCostExtraLongForProfit() : $Room->getCostBaseForProfit() ;
			$sum = $roomCost + $optionCost;
		}
		
		return (double)$sum;
	}
	public function multiEventCost(array $eventID = array())
	{
		$sum = 0.00;
		foreach($eventID as $id)
		{
			$sum += $this->singleEventCost($id);
		}//will work for now but remember this is to become a stored procedure in the future
		return (double)$sum;
	}
	private function lengthOfTime($start, $end)
	{
		global $CONFIG;
		date_default_timezone_set($CONFIG->TIMEZONE);
		return (int)date('G',strtotime($end)) - (int)date('G',strtotime($start));
		//not this will fail if meeting takes place over midnight but for now we will just have to risk it
	}
	private function getOptionTotal(array $options = array())
	{
		$connection = new PDO('mysql:host='. EMAxSTATIC::$db_host .';dbname=' . EMAxSTATIC::$db_name, EMAxSTATIC::$db_user, EMAxSTATIC::$db_password);
		$sum = 0.00;
		$sql = "SELECT SUM(`cost`) FROM `EMAx_Option` WHERE `ID`= " . EMAxSTATIC::$IMPOSSIBLE_PK_NUMBER;
		foreach($options as $option)
		{
			$sql .= " OR `ID` = " . $connection->quote($option);
		}
		$result = $connection->query($sql);
		$sum = $result->fetch(PDO::FETCH_ASSOC);
		return (double)$sum['SUM(`cost`)'];
	}
	private function getGradeTotal(array $grades = array())
	{
		$connection = new PDO('mysql:host='. EMAxSTATIC::$db_host .';dbname=' . EMAxSTATIC::$db_name, EMAxSTATIC::$db_user, EMAxSTATIC::$db_password);
		$sql = "SELECT MAX(`cost`) FROM `EMAx_Grade` WHERE `ID`= " . EMAxSTATIC::$IMPOSSIBLE_PK_NUMBER;
		foreach($grades as $grade)
		{
			$sql .= " OR `ID` = " . $connection->quote($grade);
		}
		$result = $connection->query($sql);
		$sum = $result->fetch(PDO::FETCH_ASSOC);
		return (double)$sum['MAX(`cost`)'];
	}
}
?>
