<?php
class DeleteEventModule
{
	function __construct($id)
	{
		$id = (is_numeric($id)) ? (int)$id : NULL;
		require_once('../model/EventModel.php');
		$Event = new EventModel($id);
		$Event->deleteRecord();
		unset($Event);
	}
}
?>