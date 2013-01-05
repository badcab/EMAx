<?php
require_once('../model/OptionModel.php');
$Option = new OptionModel();
$optionList = $Option->getList();

echo ('<div><form id="NEEDTOREMOVETHISAFTERTALKINGTOJUSTIN"><table>');
foreach($optionList as $option):
?>
<tr>
	<td><?= $option['name'] ?></td>
	<td>
		<input type="checkbox" name="<?= $option['id'] ?>" /> &#36;<?= $option['cost'] ?>
		
	</td>
</tr>
<?php endforeach; ?>	
</table></form></div>