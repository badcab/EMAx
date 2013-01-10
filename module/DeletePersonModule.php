<?php
class DeletePersonModule
{
	function __construct($id)
	{
		$id = (is_numeric($id)) ? (int)$id : NULL;
		require_once('../model/PersonModel.php');
		$Person = new PersonModel($id);
		$Person->deleteRecord();
		unset($Person);
	}
}
?>