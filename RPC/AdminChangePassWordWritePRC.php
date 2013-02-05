<?php
require_once('../module/ChangeUserPassword_WriteToDataBaseModule.php');
$formData = (isset($_POST['formData'])) ? $_POST['formData'] : NULL;
parse_str($formData, $writeToDB);
$user = $writeToDB['user'];
$password = $writeToDB['password'];
$ChangePassword = new ChangeUserPassword_WriteToDataBaseModule();
$ChangePassword->activate($user, $password);
?>