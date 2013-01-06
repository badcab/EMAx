<?php  
require_once('../controller/PersonController.php');
$id = (isset($_POST['id'])) ? $_POST['id'] : NULL;
$id = ( is_numeric($id)) ? $id : NULL;
$id = (int)$id;
$Person = new PersonController();
$Person->activate(abs($id));
?>