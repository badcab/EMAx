<?php
//we will need to connect to the db
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
		
		//pre-requisite sql statement
		//execute sql statement
		//registar results
		
		return $result;
	}
	
	public function optionReport($start, $end, $filter, $filterID)
	{
		
	}
}
?>
