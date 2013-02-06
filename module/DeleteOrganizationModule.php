<?php
class DeleteOrganizationModule
{
	function __construct($id)
	{
		$id = (is_numeric($id)) ? (int)$id : NULL;
		require_once('../model/OrganizationModel.php');
		$Organization = new OrganizationModel($id);
		$Organization->deleteRecord();
	}
}
?>