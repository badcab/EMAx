<?php
require_once('../configure/EMAxSTATIC.php');
class CONFIG_Model
{
	private $ClassObjectArg;
	
	function __construct()
	{
		$connection = new PDO('mysql:host='. EMAxSTATIC::$db_host .';dbname=' . EMAxSTATIC::$db_name, EMAxSTATIC::$db_user, EMAxSTATIC::$db_password);
		$sql = "SELECT * FROM `EMAx_CONFIG`";
		$query = $connection->query($sql);
		$result = $query->fetchAll();
		foreach($result as $config)
		{
			$this->ClassObjectArg[$config['property']] = $config['value'];
		}
	}
	
	public function getAll()
	{
		return $this->ClassObjectArg;	
	}
	
	public function writeChanges(){}
	
	/*
		long list of gets and sets shall go here	
	*/
	
	
}
?>