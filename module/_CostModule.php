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
		$Event = new EventModel((int)$eventID);
		$Room = $Event->getRoomLocation();
		$sum = 0.00;
		$gradeCost = 0.00;
		$optionCost = 0.00;
		$baseCost = 0.00;
		
		if( $Event->getroomReservation() == EMAxSTATIC::$FEILD_TRIP_EVENT )
		{
			/*
			Field Trips will take the flat rate (base cost) determined based on county of residence and add the costs for all
			selected events and the Highest cost grade coming. This is the per person cost, attendance is manually factored in
			at a later time. Room cost is not a factor
			*/
			$Org = $Event->getOrganization();
			$baseCost = ($Org->getsameCounty()) ? EMAxSTATIC::$BASECOST_FEILD_TRIP_IN_COUNTY : EMAxSTATIC::$BASECOST_FEILD_TRIP_OUT_OF_COUNTY ;
			$optionCost = $this->getOptionTotal($Event->getOption());
			$gradeCost = $this->getGradeTotal($Event->getGrade());
			$sum = $gradeCost + $optionCost + $baseCost;
		}
		if( $Event->getroomReservation() == EMAxSTATIC::$ROOM_RESERVATION_NON_PROFIT )
		{
			/*
			A base cost is determined based on how long the reservation is for, options selected and the cost of the room are
			then added in. Attendance is not a factor for room reservations
			*/
			$lengthOfTime = $this->lengthOfTime($Event->getstartTime(), $Event->getendTime());
			$baseCost = EMAxSTATIC::$BASECOST_NON_PROFIT + ((($lengthOfTime / 2) -1) * EMAxSTATIC::$BASECOST_NON_PROFIT_EXTRA_2HR);
			$roomCost = $Room->getCost();
			$optionCost = $this->getOptionTotal($Event->getOption());
			$sum = $baseCost + $roomCost + $optionCost;
		}
		if( $Event->getroomReservation() == EMAxSTATIC::$ROOM_RESERVATION_FOR_PROFIT )
		{
			/*
			A base cost is determined based on how long the reservation is for, options selected and the cost of the room are
			then added in. Attendance is not a factor for room reservations
			*/
			$lengthOfTime = $this->lengthOfTime($Event->getstartTime(), $Event->getendTime());
			$baseCost = EMAxSTATIC::$BASECOST_FOR_PROFIT + ((($lengthOfTime / 2) -1) * EMAxSTATIC::$BASECOST_FOR_PROFIT_EXTRA_2HR);
			$roomCost = $Room->getCost();
			$optionCost = $this->getOptionTotal($Event->getOption());
			$sum = $baseCost + $roomCost + $optionCost;
		}
error_log("========Summery========== \n");			
error_log(" Grade Cost: \t" . $gradeCost ."\n Option Cost: \t". $optionCost ."\n Base Cost: \t". $baseCost ."\n Total: \t" . $sum . "\n");		
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
		date_default_timezone_set(EMAxSTATIC::$TIMEZONE);
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
/*
echo("==========Options============ \n");		
echo(var_dump($options) . " var dump option \n");
echo(var_dump($sum) . " var dump sum \n");
echo((double)$sum['SUM(`cost`)']. " return value \n");
echo("\n");
*/
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
/*
echo("==========Grades============ \n");		
echo(var_dump($grades) . " var dump grades \n");
echo(var_dump($sum) . " var dump sum \n");
echo((double)$sum['MAX(`cost`)']. " return value \n");
echo("\n");
*/
		return (double)$sum['MAX(`cost`)'];
	}
}
?>
