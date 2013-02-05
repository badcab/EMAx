<?php
require_once('../model/LoginModel.php');
$Login = new LoginModel();
$loginList = $Login->getList()
?>
<div>
	<form>
		<table>
		<tr>
			<td>Select User</td>
			<td>
				<select name="user">
				<?php foreach($loginList as $user): ?>
					<option value="<?= $user['id'] ?>"> <?= $user['name'] ?> </option>
				<?php endforeach; ?>	
				</select>			
			</td>
		</tr>
		<tr>
			<td>Desired Password</td>
			<td><input type="text" name="password" /></td>
		</tr>
		</table>
	</form>
</div>