<?php
$formData = (isset($_POST['formData'])) ? $_POST['formData'] : NULL;
parse_str($formData, $writeToDB);

$user = $writeToDB['user'];
$currentPassword = $writeToDB['currentPassword'];
$newPassword1 = $writeToDB['newPassword'];
$newPassword2 = $writeToDB['confirmPassword'];

require_once('../module/LoginModule.php');
$Login = new LoginModule($user, $currentPassword);
$isValidLogin = $Login->activate();
if($isValidLogin)
{
	if($newPassword1 == $newPassword2)
	{
		require_once('../model/LoginModel.php');
		$Login = new LoginModel($user);
		$Login->setpassword($newPassword1);
		$Login->writeData();
		echo('Password Changed');
		return;
	} 
	echo('Error, Password not changed. Did not match');
}
else
{
	echo('Error, Password not changed');
}
?>