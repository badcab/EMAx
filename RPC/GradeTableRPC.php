<?php
require_once('../model/GradeModel.php');
$Grade = new GradeModel();
$gradeList = $Grade->getList();

echo ('<div><form><table>');
foreach($gradeList as $grade):
?>
<tr>
	<td><?= $grade['name'] ?></td>
	<td><input type="checkbox" name="<?= $grade['id'] ?>" /> &#36;<?= $grade['cost'] ?></td>
</tr>
<?php endforeach; ?>	
</table></form></div>