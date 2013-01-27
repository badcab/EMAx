<?php 
require_once('../model/_ReportModel.php');
$start = (isset($_POST['start'])) ? $_POST['start'] : NULL;
$end = (isset($_POST['end'])) ? $_POST['end'] : NULL;
$report = new _ReportModel();
$reportResult = $report->attendanceReport($start, $end);
?>

<p>
Total Kids Field Trip: <?= $reportResult['Total_Kids_Field_Trip'] ?>
</p>
<p>
Total income from Field Trip: $<?= $reportResult['Total_income_Field_Trip']; ?>
</p>
<p>
Total Room Reservations: <?= $reportResult['Total_Room_Reservations'] ?>
</p>
<p>
Total income from Room Reservations: $<?= $reportResult['Total_income_Room_Reservations'] ?>
</p>
