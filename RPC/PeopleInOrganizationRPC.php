<?php  
require_once('../model/PersonModel.php');
require_once('../model/OrganizationModel.php');
$id = (isset($_POST['orgID'])) ? $_POST['orgID'] : NULL;
$id = (is_numeric($id)) ? abs((int)$id) : NULL;
$Organization = new OrganizationModel($id);
$Person = new PersonModel();
$personList = $Person->getListByOrganization($Organization);
echo('<select name="dropDownPerson" onchange="setPersonInForm(this)" id="PersonEventDropDown">');
echo('<option></option>');
foreach($personList as $person):
?>
	<option value="<?= $person['id'] ?>"><?= $person['name'] ?></option>
<?php endforeach; ?>	
</select>
<script type="text/javascript" >
document.getElementById('PersonEvent').value = $("#PersonEventDropDown").val();

//should be
//$("#PersonEventDropDown").val($("#PersonEvent").val());
</script>