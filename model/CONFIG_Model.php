<?php
class CONFIG_Model
{
	private $ClassObjectArg;
	private $connection;
	
	function __construct($db_host, $db_name, $db_user, $db_password)
	{
		$connection = new PDO('mysql:host='. $db_host .';dbname=' . $db_name, $db_user, $db_password);
		$this->connection = $connection;
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
	
	public function writeChanges()
	{
		$sql = "";
		$allKeys = array_keys($this->ClassObjectArg);

		foreach($allKeys as $config)
		{
			$configValue = $this->connection->quote($this->ClassObjectArg[$config]);
			$configProperty = $this->connection->quote($config);
			$sql .= "UPDATE `EMAx_CONFIG` SET `value`={$configValue} WHERE `property`={$configProperty};\n";
		}		
		$this->connection->exec($sql);
	}
	
	public function getAddressOfOrg()
	{
		return $this->ClassObjectArg["ADDRESS_OF_ORG"];
	}
	
	public function getAreaCode()
	{
		return $this->ClassObjectArg["AREA_CODE"];
	}

	public function getCounty()
	{
		return $this->ClassObjectArg["COUNTY"];
	}

	public function getDefaultState()
	{
		return $this->ClassObjectArg["DEFAULT_STATE"];
	}

	public function getFallEmailBody()
	{
		return $this->ClassObjectArg["EMAIL_BODY_ADD_ON_FALL"];
	}

	public function getSpringEmailBody()
	{
		return $this->ClassObjectArg["EMAIL_BODY_ADD_ON_SPRING"];
	}

	public function getSummerEmailBody()
	{
		return $this->ClassObjectArg["EMAIL_BODY_ADD_ON_SUMMER"];
	}

	public function getWinterEmailBody()
	{
		return $this->ClassObjectArg["EMAIL_BODY_ADD_ON_WINTER"];
	}

	public function getEmailOfOrg()
	{
		return $this->ClassObjectArg["EMAIL_OF_ORG"];
	}

	public function getgooglePassword()
	{
		return $this->ClassObjectArg["googlePassword"];
	}

	public function getgoogleUserName()
	{
		return $this->ClassObjectArg["googleUserName"];
	}

	public function getHoursBeforeExtraCharge()
	{
		return $this->ClassObjectArg["HOURS_BEFORE_EXTRA_CHARGE_ROOM_RESERVATION"];
	}

	public function getNameOfOrg()
	{
		return $this->ClassObjectArg["NAME_OF_ORG"];
	}

	public function getJQuery()
	{
		return $this->ClassObjectArg["PATH_JQUERY"];
	}

	public function getJQueryUI()
	{
		return $this->ClassObjectArg["PATH_JQUERY_UI"];
	}

	public function getJQueryUIcss()
	{
		return $this->ClassObjectArg["PATH_JQUERY_UI_CSS"];
	}

	public function getZend()
	{
		return $this->ClassObjectArg["PATH_ZEND"];
	}

	public function getPhoneOfOrg()
	{
		return $this->ClassObjectArg["PHONE_OF_ORG"];
	}

	public function getTimeZone()
	{
		return $this->ClassObjectArg["TIMEZONE"];
	}

	public function getUseGoogleCal()
	{
		return $this->ClassObjectArg["USE_GOOGLE_CAL"];
	}
	
	public function getMinimumFieldTripIncome()
	{
		return $this->ClassObjectArg["MINIMUM_FIELD_TRIP_INCOME"];
	}	
	
	public function getSurchargeForOutOfCounty()
	{
		return $this->ClassObjectArg["SURCHARGE_FOR_OUT_OF_COUNTY"];
	}
	
	public function setAddressOfOrg($value)
	{
		$value = $this->connection->quote($value);
		$this->ClassObjectArg["ADDRESS_OF_ORG"] = $value;
	}

	public function setAreaCode($value)
	{
		$value = $this->connection->quote($value);
		$this->ClassObjectArg["AREA_CODE"] = $value;
	}

	public function setCounty($value)
	{
		$value = $this->connection->quote($value);
		$this->ClassObjectArg["COUNTY"] = $value;
	}

	public function setDefaultState($value)
	{
		$value = $this->connection->quote($value);
		$this->ClassObjectArg["DEFAULT_STATE"] = $value;
	}

	public function setFallEmailBody($value)
	{
		$value = $this->connection->quote($value);
		$this->ClassObjectArg["EMAIL_BODY_ADD_ON_FALL"] = $value;
	}

	public function setSpringEmailBody($value)
	{
		$value = $this->connection->quote($value);
		$this->ClassObjectArg["EMAIL_BODY_ADD_ON_SPRING"] = $value;
	}

	public function setSummerEmailBody($value)
	{
		$value = $this->connection->quote($value);
		$this->ClassObjectArg["EMAIL_BODY_ADD_ON_SUMMER"] = $value;
	}

	public function setWinterEmailBody($value)
	{
		$value = $this->connection->quote($value);
		$this->ClassObjectArg["EMAIL_BODY_ADD_ON_WINTER"] = $value;
	}

	public function setEmailOfOrg($value)
	{
		$value = $this->connection->quote($value);
		$this->ClassObjectArg["EMAIL_OF_ORG"] = $value;
	}

	public function setgooglePassword($value)
	{
		$value = $this->connection->quote($value);
		$this->ClassObjectArg["googlePassword"] = $value;
	}

	public function setgoogleUserName($value)
	{
		$value = $this->connection->quote($value);
		$this->ClassObjectArg["googleUserName"] = $value;
	}

	public function setHoursBeforeExtraCharge($value)
	{
		$value = $this->connection->quote($value);
		$this->ClassObjectArg["HOURS_BEFORE_EXTRA_CHARGE_ROOM_RESERVATION"] = $value;
	}

	public function setNameOfOrg($value)
	{
		$value = $this->connection->quote($value);
		$this->ClassObjectArg["NAME_OF_ORG"] = $value;
	}

	public function setJQuery($value)
	{
		$value = $this->connection->quote($value);
		$this->ClassObjectArg["PATH_JQUERY"] = $value;
	}

	public function setJQueryUI($value)
	{
		$value = $this->connection->quote($value);
		$this->ClassObjectArg["PATH_JQUERY_UI"] = $value;
	}

	public function setJQueryUIcss($value)
	{
		$value = $this->connection->quote($value);
		$this->ClassObjectArg["PATH_JQUERY_UI_CSS"] = $value;
	}

	public function setZend($value)
	{
		$value = $this->connection->quote($value);
		$this->ClassObjectArg["PATH_ZEND"] = $value;
	}

	public function setPhoneOfOrg($value)
	{
		$value = $this->connection->quote($value);
		$this->ClassObjectArg["PHONE_OF_ORG"] = $value;
	}

	public function setTimeZone($value)
	{
		$value = $this->connection->quote($value);
		$this->ClassObjectArg["TIMEZONE"] = $value;
	}

	public function setUseGoogleCal($value)
	{
		$value = $this->connection->quote($value);
		$this->ClassObjectArg["USE_GOOGLE_CAL"] = $value;
	}	
	
	public function setMinimumFieldTripIncome($value)
	{
		$value = $this->connection->quote($value);
		$this->ClassObjectArg["MINIMUM_FIELD_TRIP_INCOME"] = $value;
	}	
	
	public function setSurchargeForOutOfCounty($value)
	{
		$value = $this->connection->quote($value);
		$this->ClassObjectArg["SURCHARGE_FOR_OUT_OF_COUNTY"] = $value;
	}
}
?>