<?php  
require_once('../controller/ReportController.php');
$id = (isset($_POST['id'])) ? $_POST['id'] : NULL;
$id = ( is_numeric($id)) ? $id : NULL;
$id = (int)$id;
$Report = new ReportController();
$Report->activate(abs($id));
?>