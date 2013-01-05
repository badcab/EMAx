<?php  
require_once('../controller/OrganizationController.php');
$id = (isset($_POST['id'])) ? $_POST['id'] : NULL;
$id = ( is_numeric($id)) ? $id : NULL;
$id = (int)$id;
$Organization = new OrganizationController();
$Organization->activate(abs($id));
?>
