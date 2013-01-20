<?php 
require_once('../model/_ReportModel.php');
$start = (isset($_POST['start'])) ? $_POST['start'] : NULL;
$end = (isset($_POST['end'])) ? $_POST['end'] : NULL;

$filter = (isset($_POST['filter'])) ? $_POST['filter'] : NULL;
$filterID = (isset($_POST['filterID'])) ? $_POST['filterID'] : NULL;

$report = new _ReportModel();
$reportResult = $report->optionReport($start, $end, $filter, $filterID);
?>
<p>it works up to this point</p>