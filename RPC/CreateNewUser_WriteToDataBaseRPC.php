<?php
require_once('../module/CreateNewUser_WriteToDataBaseModule.php');
$CreateUser = new CreateNewUser_WriteToDataBaseModule();
$userName = (isset($_POST['userName'])) ? $_POST['userName'] : NULL; 
$password = (isset($_POST['password'])) ? $_POST['password'] : NULL; 
$CreateUser->activate($userName, $password);
?>