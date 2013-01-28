<?php 
require_once('../model/_ReportModel.php');
require_once('../configure/EMAxSTATIC.php');
date_default_timezone_set(EMAxSTATIC::$TIMEZONE);
$start = (isset($_POST['start'])) ? $_POST['start'] : NULL;
$end = (isset($_POST['end'])) ? $_POST['end'] : NULL;

$report = new _ReportModel();
$reportResult = $report->dateRangeReport($start, $end);

?>
<div class="reportOverflow">
<table class="searchTable">
<tr>

		<th>Date</th>
		<th>Start Time</th>
		<th>End Time</th>
		<th>Organization</th>
		<th>Contact Person</th>
		<th>Phone Number</th>
		<th>Email</th>
		<th> <!-- left blank for select button --> </th>

</tr>

<?php
foreach($reportResult as $record):
?>
<tr>
		<td><?= date('l F j', strtotime($record['startTime'])) ?></td>
		<td><?= date('g:i a', strtotime($record['startTime'])) ?></td>
		<td><?= date('g:i a', strtotime($record['endTime'])) ?></td>
		<td><?= $record['name'] ?></td>
		<td><?= $record['fName'] ?> <?= $record['lName'] ?></td>
		<td><?= $record['phoneNumber'] ?></td>
		<td><?= $record['emailAddress'] ?></td>
		<td><input type="button" onclick="LoadContent.loadContent( 'RPC/SearchResultsRPC.php', <?= $record['ID'] ?> , 'Event')" value="select"/></td>
</tr>
<?php 
endforeach;
?>
</table>
</div>