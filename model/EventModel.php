<?php

require_once('OrganizationModel.php');
require_once('PersonModel.php');
require_once('RoomLocationModel.php');
require_once('LoginModel.php');
require_once('../configure/EMAxSTATIC.php');
class EventModel
{
	private $ClassObjectArg;

	function __construct($id = NULL)
	{

    	$connection = new PDO('mysql:host='. EMAxSTATIC::$db_host .';dbname=' . EMAxSTATIC::$db_name, EMAxSTATIC::$db_user, EMAxSTATIC::$db_password);
		$sql = "SELECT * FROM `EMAx_Event` WHERE ID=" . $connection->quote($id);
		$result = $connection->query($sql);
		$currentDBvalues = ($result) ? $result->fetch(PDO::FETCH_OBJ) : NULL ;

		if($currentDBvalues)
		{
			$Organization = $currentDBvalues->EMAx_Organization_ID;
			$Person = $currentDBvalues->EMAx_Person_ID;
			$roomReservation = $currentDBvalues->roomReservation;
			$RoomLocation = $currentDBvalues->EMAx_RoomLocation_ID;
			$Login = $currentDBvalues->EMAx_Login_ID;
			$startTime = $currentDBvalues->startTime;
			$endTime = $currentDBvalues->endTime;
			$attendance = $currentDBvalues->attendance;
			$havingLunch = $currentDBvalues->havingLunch;
			$googlURI = $currentDBvalues->googlURI;
			$hasPaid = $currentDBvalues->hasPaid;
			$notes = $currentDBvalues->notes;
			$grades = array();
			$option = array();

				$gradeSQL = "SELECT * FROM `EMAx_GradeEventMap` WHERE `EMAx_GradeEventMap`.`EMAx_Event_ID` = " . $connection->quote($id);
				$gradeResult =	$connection->query($gradeSQL);
				$gradeRecords = ($gradeResult) ? $gradeResult->fetchAll() : array() ;
				foreach($gradeRecords as $record)
				{
					$grades[] = (int)$record['EMAx_Grade_ID'];
				}

				$optionSQL = "SELECT * FROM `EMAx_OptionEventMap` WHERE `EMAx_OptionEventMap`.`EMAx_Event_ID` = " . $connection->quote($id);
				$optionResult = $connection->query($optionSQL);
				$optionRecords = ($optionResult) ? $optionResult->fetchAll() : array() ;
				foreach($optionRecords as $record)
				{
					$option[] = (int)$record['EMAx_Option_ID'];
				}
		}

		else
		{
			$id = NULL;
			$Organization = NULL;
			$Person = NULL;
			$roomReservation = NULL;
			$RoomLocation = NULL;
			$Login = NULL;
			$startTime = NULL;
			$endTime = NULL;
			$attendance = NULL;
			$havingLunch = NULL;
			$googlURI = NULL;
			$hasPaid = NULL;
			$notes = NULL;
			$grades = array();
			$option = array();
		}
		$connection = NULL;
		$this->ClassObjectArg = array(
			'ID' => $id,
			'Organization' => $Organization,
			'Person' => $Person,
			'RoomLocation' => $RoomLocation,
			'Login' => $Login,
			'startTime' => $startTime,
			'endTime' => $endTime,
			'attendance' => $attendance,
			'havingLunch' => $havingLunch,
			'googlURI' => $googlURI,
			'hasPaid' => $hasPaid,
			'notes' => $notes,
			'grades' => $grades,
			'option' => $option,
			'roomReservation' => $roomReservation
		);
	}

	public function writeData()
	{

		$connection = new PDO('mysql:host='. EMAxSTATIC::$db_host .';dbname=' . EMAxSTATIC::$db_name, EMAxSTATIC::$db_user, EMAxSTATIC::$db_password);

		$googleURI = NULL;
		$Organization = $this->getOrganization();
		$Location = $this->getRoomLocation();

		if($this->ClassObjectArg['ID'])
		{
			if(EMAxSTATIC::$USE_GOOGLE_CAL)
			{
				$google_date = date('Y-m-d H:i:s', strtotime($this->getstartTime()));
				$google_startTime = date('Y-m-d H:i:s', strtotime($this->getstartTime()));
				$google_endTime = date('Y-m-d H:i:s', strtotime($this->getendTime()));
				$google_name = $Organization->getOrganization();
				$google_location = $Location->getRoomLocation();
				$google_discription = $Organization->getOrganization() . ' will do ' . ' option list ' . ' grade list ' ;
				$google_eventUri = $this->ClassObjectArg['googlURI'];
				$googleURI = '';
				require_once('../module/GoogleCalanderModule.php');
				$Google = new GoogleCalanderModule();
				$googleURI = $Google->Edit_gCal_Event(
					$google_date,
					$google_startTime,
					$google_endTime,
					$google_location,
					$google_name,
					$google_discription,
					$google_eventUri
				);
			}

			$sql = "
				UPDATE `EMAx_Event` SET `EMAx_Organization_ID`=". $connection->quote($this->ClassObjectArg['Organization'])
				.",`EMAx_Person_ID`=". $connection->quote($this->ClassObjectArg['Person'])
				.",`EMAx_RoomLocation_ID`=". $connection->quote($this->ClassObjectArg['RoomLocation'])
				.",`EMAx_Login_ID`=". $connection->quote($this->ClassObjectArg['Login'])
				.",`startTime`=". $connection->quote($this->ClassObjectArg['startTime'])
				.",`endTime`=". $connection->quote($this->ClassObjectArg['endTime'])
				.",`attendance`=". $connection->quote($this->ClassObjectArg['attendance'])
				.",`havingLunch`=". $connection->quote($this->ClassObjectArg['havingLunch'])
				.",`googlURI`=". $connection->quote($googleURI)
				.",`hasPaid`=". $connection->quote($this->ClassObjectArg['hasPaid'])
				.",`notes`=". $connection->quote($this->ClassObjectArg['notes'])
				.",`roomReservation`=" . $connection->quote($this->ClassObjectArg['roomReservation'])
				." WHERE `ID`=" . $connection->quote($this->ClassObjectArg['ID']) ;
			$success = $connection->exec($sql);
		}

		else
		{
			if(EMAxSTATIC::$USE_GOOGLE_CAL)
			{
				$google_date = date('Y-m-d H:i:s', strtotime($this->getstartTime()));
				$google_startTime = date('Y-m-d H:i:s', strtotime($this->getstartTime()));
				$google_endTime = date('Y-m-d H:i:s', strtotime($this->getendTime()));
				$google_name = $Organization->getOrganization();
				$google_location = $Location->getRoomLocation();
				$google_discription = $Organization->getOrganization() . ' will do ' . ' option list ' . ' grade list ' ;
				$google_eventUri = $this->ClassObjectArg['googlURI'];
				$googleURI = '';
				require_once('../module/GoogleCalanderModule.php');
				$Google = new GoogleCalanderModule();
				$googleURI = $Google->Add_gCal_Event(
					$google_date,
					$google_startTime,
					$google_endTime,
					$google_location,
					$google_name,
					$google_discription
				);
			}

			$sql =
				"INSERT INTO `EMAx_Event`(
					`EMAx_Organization_ID`,
					`EMAx_Person_ID`,
					`EMAx_RoomLocation_ID`,
					`EMAx_Login_ID`,
					`startTime`,
					`endTime`,
					`attendance`,
					`havingLunch`,
					`googlURI`,
					`hasPaid`,
					`notes`,
					`roomReservation`
				) VALUES (
					". $connection->quote($this->ClassObjectArg['Organization']) .",
					". $connection->quote($this->ClassObjectArg['Person']) .",
					". $connection->quote($this->ClassObjectArg['RoomLocation']) .",
					". $connection->quote($this->ClassObjectArg['Login']) .",
					". $connection->quote($this->ClassObjectArg['startTime']) .",
					". $connection->quote($this->ClassObjectArg['endTime']) .",
					". $connection->quote($this->ClassObjectArg['attendance']) .",
					". $connection->quote($this->ClassObjectArg['havingLunch']) .",
					". $connection->quote($googleURI) .",
					". $connection->quote($this->ClassObjectArg['hasPaid']) .",
					". $connection->quote($this->ClassObjectArg['notes']) .",
					". $connection->quote($this->ClassObjectArg['roomReservation']) ."
				);";

			$isRoomAvalible = $this->doubleBookProtection(
				$this->ClassObjectArg['startTime'],
				$this->ClassObjectArg['endTime'],
				$this->ClassObjectArg['RoomLocation']
			);
			if($isRoomAvalible)
			{
				$connection->beginTransaction();
					$connection->exec($sql);
					$lastInsertedID = $connection->lastInsertId();
				$connection->commit();
				$this->ClassObjectArg['ID'] = (int)$lastInsertedID;
				$success = $lastInsertedID;
			}
			else
			{
				$success = FALSE;
			}
		}

		$connection->exec("DELETE FROM `EMAx_GradeEventMap` WHERE `EMAx_Event_ID` = '". $this->getID() ."'");
		$connection->exec("DELETE FROM `EMAx_OptionEventMap` WHERE `EMAx_Event_ID` = '". $this->getID() ."'");

		foreach($this->ClassObjectArg['grades'] as $record)
		{
			$sql =
				"INSERT INTO `EMAx_GradeEventMap`(`EMAx_Event_ID`, `EMAx_Grade_ID`)
				VALUES (" . $this->getID() . "," . $record . ")";
			$connection->exec($sql);
		}

		foreach($this->ClassObjectArg['option'] as $record)
		{
			$sql =
				"INSERT INTO `EMAx_OptionEventMap`(`EMAx_Event_ID`, `EMAx_Option_ID`)
				VALUES (" . $this->getID() . "," . $record . ")";
			$connection->exec($sql);
		}

		if(EMAxSTATIC::$USE__EMAIL)
		{
			require_once('../module/MailModule.php');
			$mail = new MailModule();
			$mail->activate();	
		}

		$connection = NULL;
		return $success;
	}

	public function getID()
	{
		return (int)$this->ClassObjectArg['ID'];
	}

	public function deleteRecord()
	{
		$connection = new PDO('mysql:host='. EMAxSTATIC::$db_host .';dbname=' . EMAxSTATIC::$db_name, EMAxSTATIC::$db_user, EMAxSTATIC::$db_password);

		require_once('../module/GoogleCalanderModule.php');
		$Google = new GoogleCalanderModule();
		$Google->Delete_gCal_Event( $this->ClassObjectArg['googlURI'] );

		$connection->exec("DELETE FROM `EMAx_OptionEventMap` WHERE `EMAx_Event_ID` = '". $this->getID() ."'");
		$connection->exec("DELETE FROM `EMAx_GradeEventMap` WHERE `EMAx_Event_ID` = '". $this->getID() ."'");
		$connection->exec("DELETE FROM `EMAx_Event` WHERE `ID`=" . $connection->quote($this->getID()));
	}

	private function doubleBookProtection($startTime, $endTime, $roomID)
	{
		require_once('../module/DoubleBookModule.php');
		$doubleBook = new DoubleBookModule($startTime, $endTime, $roomID);
		return $doubleBook->activate();
	}

	public function getOrganization()
	{
		$Organization = new OrganizationModel((int)$this->ClassObjectArg['Organization']);
		return $Organization;
	}

	public function getPerson()
	{
		$Person = new PersonModel((int)$this->ClassObjectArg['Person']);
		return $Person;
	}

	public function getRoomLocation()
	{
		$RoomLocation = new RoomLocationModel((int)$this->ClassObjectArg['RoomLocation']);
		return $RoomLocation;
	}

	public function getLogin()
	{
		$Login = new LoginModel((int)$this->ClassObjectArg['Login']);
		return $Login;
	}

	public function getstartTime()
	{
		return $this->ClassObjectArg['startTime'];
	}

	public function getendTime()
	{
		return $this->ClassObjectArg['endTime'];
	}

	public function getOption()
	{
		return $this->ClassObjectArg['option'];
	}

	public function getGrade()
	{
		return $this->ClassObjectArg['grades'];
	}

	public function setOption($value)
	{
		$this->ClassObjectArg['option'] = explode(',', $value);
	}

	public function setGrade($value)
	{
		$this->ClassObjectArg['grades'] = explode(',', $value);
	}

	public function getattendance()
	{
		return (int)$this->ClassObjectArg['attendance'];
	}

	public function gethavingLunch()
	{
		return (int)$this->ClassObjectArg['havingLunch'];
	}

	public function gethasPaid()
	{
		return (int)$this->ClassObjectArg['hasPaid'];
	}

	public function getnotes()
	{
		return $this->ClassObjectArg['notes'];
	}

	public function setOrganization(OrganizationModel $value)
	{
		$this->ClassObjectArg['Organization'] = (int)$value->getID();
	}

	public function setPerson(PersonModel $value)
	{
		$this->ClassObjectArg['Person'] = (int)$value->getID();
	}

	public function setRoomLocation(RoomLocationModel $value)
	{
		$this->ClassObjectArg['RoomLocation'] = (int)$value->getID();
	}

	public function setLogin(LoginModel $value)
	{
		$this->ClassObjectArg['Login'] = (int)$value->getID();
	}

	public function setstartTime($value) //format here
	{
		$value = ($value == '') ? NULL : $value;
		$this->ClassObjectArg['startTime'] = $value;
	}

	public function setendTime($value) //format
	{
		$value = ($value == '') ? NULL : $value;
		$this->ClassObjectArg['endTime'] = $value;
	}

	public function setattendance($value) //force to int
	{
		$this->ClassObjectArg['attendance'] = (int)$value;
	}

	public function sethavingLunch($value)
	{
		$value = ($value == '') ? NULL : $value;
		$this->ClassObjectArg['havingLunch'] = (int)$value;
	}

	public function sethasPaid($value)
	{
		$value = ($value == '') ? NULL : $value;
		$this->ClassObjectArg['hasPaid'] = (int)$value;
	}

	public function setnotes($value)
	{
		$value = ($value == '') ? NULL : $value;
		$this->ClassObjectArg['notes'] = $value;
	}

	public function getroomReservation()
	{
		return (int)$this->ClassObjectArg['roomReservation'];
	}

	public function setroomReservation($value)
	{
		$this->ClassObjectArg['roomReservation'] = (int)$value;
	}
}
?>