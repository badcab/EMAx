<?php  
require_once('../controller/EventController.php');
$id = (isset($_POST['id'])) ? $_POST['id'] : NULL;
$id = ( is_numeric($id)) ? $id : NULL;
$id = (int)$id;
$Event = new EventController();
$Event->activate(abs($id));
?>
