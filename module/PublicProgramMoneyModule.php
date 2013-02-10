<?php
require_once('../configure/EMAxSTATIC.php');
class PublicProgramMoneyModule
{
	public function activate($Event, $expenses, $revenue)
	{
		$eventID = $Event->getID();
		$expenses = (double)$expenses;
		$revenue = (double)$revenue;
		
		$connection = new PDO('mysql:host='. EMAxSTATIC::$db_host .';dbname=' . EMAxSTATIC::$db_name, EMAxSTATIC::$db_user, EMAxSTATIC::$db_password);

		$result = $connection->query("SELECT * FROM `EMAx_PublicProgramMoney` WHERE `EMAx_Event_ID` = {$eventID}");
		
		if($result)
		{
			$sql = 
			"INSERT INTO `EMAx_PublicProgramMoney`(`EMAx_Event_ID`, `revenue`, `expenses`) VALUES ({$eventID},{$revenue},{$expenses})";
		}
		else 
		{
			$sql = 
			"UPDATE `EMAx_PublicProgramMoney` SET `revenue` = {$revenue},`expenses` = {$expenses} WHERE `EMAx_Event_ID` = {$eventID}";
		}
		$connection->exec($sql);
		$connection = NULL;
		
	}
}
?>