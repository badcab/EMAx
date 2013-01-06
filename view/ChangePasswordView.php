<div>
<form id="changePasswordForm">
<table>

<tr>
	<td>User Name</td>
	<td><?= $_SESSION['user'] ?></td>
	<input type="hidden" name="user" value="<?= $_SESSION['user'] ?>" />
</tr><tr>

	<td>Current Password</td>
	<td><input type="password" name="currentPassword" /></td>
</tr><tr>

	<td>New Password</td>
	<td><input type="password" name="newPassword" /></td>
</tr><tr>

	<td>Confirm New Password</td>
	<td><input type="password" name="confirmPassword" /></td>
</tr>

</table>
</form>
</div>



