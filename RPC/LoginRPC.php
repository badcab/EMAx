<?php  
require_once('../controller/LoginController.php');
//$id = (isset($_POST['id'])) ? $_POST['id'] : NULL;
//$id = ( is_numeric($id)) ? $id : NULL;
//$id = (int)$id;
$Login = new LoginController();
$Login->activate();
?>