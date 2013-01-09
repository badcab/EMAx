<?php
$table = (isset($_POST['table'])) ? $_POST['table'] : NULL;
$id_arr = (isset($_POST['ids'])) ? explode(',', $_POST['ids']) : NULL;
$name_arr = array();

require_once('../model/' . $table . 'Model.php');

foreach($id_arr as $id)
{
	$id = (int)$id;
	$object = ($table == 'Grade') ? new GradeModel($id) : new OptionModel($id);
	$name_arr[] = ($table == 'Grade') ? $object->getGrade() : $object->getOption();
	unset($object);
}
echo(implode(', ', $name_arr));
?>