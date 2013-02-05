<?php
require_once('../module/DeleteUser_WriteToDataBaseModule.php');
$formData = (isset($_POST['formData'])) ? $_POST['formData'] : NULL;
parse_str($formData, $writeToDB);
$user = $writeToDB['user'];
$DeleteUser = new DeleteUser_WriteToDataBaseModule();
$DeleteUser->activate($user);
?>