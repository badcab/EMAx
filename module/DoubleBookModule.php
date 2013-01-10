<?php
require_once('../configure/EMAxSTATIC.php');
class DoubleBookModule
{
	private $eventStart;
	private $eventEnd;
	private $roomLocation;

	function __construct($eventStart, $eventEnd, $roomLocation)
	{
		date_default_timezone_set(EMAxSTATIC::$TIMEZONE);
		$this->eventStart = date("Y-m-d H:i:s", $eventStart);
		$this->eventEnd = date("Y-m-d H:i:s", $eventEnd);
		$this->roomLocation = (int)$roomLocation;
	}

	function activate()
	{
		//return true or false
		//true means continue with the booking
		$sql = "SELECT * FROM `EMAx_Event` 
			WHERE  {$this->eventStart} < `endTime` 
			AND {$this->eventEnd} > `startTime` 
			AND `EMAx_RoomLocation_ID` = {$this->roomLocation}";
			
		$connection = new PDO(
			'mysql:host='. EMAxSTATIC::$db_host .';dbname=' . EMAxSTATIC::$db_name, 
			EMAxSTATIC::$db_user, 
			EMAxSTATIC::$db_password
		);
		$result = ( $connection->query($sql) ) ? TRUE : FALSE ;
		$connection = NULL;
		return $result;
	}
}
?>
