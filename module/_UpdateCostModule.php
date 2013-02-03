<?php
require_once('_CostModule.php');
require_once('../configure/EMAxSTATIC.php');
class _UpdateCostModule
{
//updates cost for all affected events
	private $UpdateCost;
	function __construct()
	{
		$this->UpdateCost = new _CostModule();
	}
	public function fkGrade($fkID)
	{
		$fkID = (int)$fkID;
		$arr = $this->getArrListOfFK($fkID, 'EMAx_GradeEventMap', 'EMAx_Grade_ID');
		$this->UpdateCost->multiEventCost($arr);
	}
	public function fkOption($fkID)
	{
		$fkID = (int)$fkID;
		$arr = $this->getArrListOfFK($fkID, 'EMAx_OptionEventMap', 'EMAx_Option_ID');
		$this->UpdateCost->multiEventCost($arr);
	}
	private function getArrListOfFK($fkID, $tableName, $fkCol, $targetCol = 'EMAx_Event_ID')
	{
		$connection = new PDO('mysql:host='. EMAxSTATIC::$db_host .';dbname=' . EMAxSTATIC::$db_name, EMAxSTATIC::$db_user, EMAxSTATIC::$db_password);
		$sql = "SELECT `{$targetCol}` FROM `{$tableName}` WHERE `{$fkCol}` = {$fkID}";
		$query = $connection->query($sql);
		$result = $query->fetchAll(PDO::FETCH_ASSOC);
		$arr = array();
		foreach($result as $fk)
		{
			$arr[] = $fk[$targetCol];
		}
		$connection = NULL;
		return $arr;
	}
}
?>
