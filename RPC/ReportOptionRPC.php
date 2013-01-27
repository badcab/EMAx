<?php 
require_once('../model/_ReportModel.php');
$start = (isset($_POST['start'])) ? $_POST['start'] : NULL;
$end = (isset($_POST['end'])) ? $_POST['end'] : NULL;

$filter = (isset($_POST['filter'])) ? $_POST['filter'] : NULL;
$filterID = (isset($_POST['filterID'])) ? (int)$_POST['filterID'] : NULL;

$report = new _ReportModel();
$reportResult = $report->optionReport($start, $end, $filter, $filterID);
//some logic here to skip loop and echo text "nothing"
foreach($reportResult as $record):
?>
<p>it works up to this point should become a list of events</p>
<?php 
endforeach;
?>
Hello World OptionsRPC