<?php 
require_once('configure/EMAxSTATIC.php');
class GoogleCalanderModule
{
	private $service;
	private $client;
	
	function __construct()
	{
		$oldPath = set_include_path(get_include_path() . PATH_SEPARATOR . EMAxSTATIC::$PATH_ZEND);
		
		require_once ('Zend/Loader.php');
		Zend_Loader::loadClass('Zend_Gdata');
		Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
		Zend_Loader::loadClass('Zend_Gdata_Calendar');

		try 
		{
   		$this->client = Zend_Gdata_ClientLogin::getHttpClient(EMAxSTATIC::$googleUserName, EMAxSTATIC::$googlePassword, 'cl');
		} 
		catch (Zend_Gdata_App_CaptchaRequiredException $cre) 
		{
    		error_log('URL of CAPTCHA image: ' . $cre->getCaptchaUrl());
    		error_log( 'Token ID: ' . $cre->getCaptchaToken() );
		} 
		catch (Zend_Gdata_App_AuthException $ae) 
		{
   		error_log( 'Problem authenticating: ' . $ae->exception() );
		}
 
		$this->service = new Zend_Gdata_Calendar($this->client);
 
		try 
		{
    		$listFeed= $this->service->getCalendarListFeed();
		} 
		catch (Zend_Gdata_App_Exception $e) 
		{

		}
	}
	
	public function activate()
	{
		/* Does nothing, only here for consistency */
	}

	public function Add_gCal_Event($event_date, $starttime, $endtime, $location, $name, $discr)
	{
		try
		{	
			$event = $this->service->newEventEntry();
			$event->title = $this->service->newTitle($name);
			$event->where = array($this->service->newWhere($location));
			$event->content = $this->service->newContent($discr);//not really needed will leave here just in case

			$event_date = date('Y-m-d', strtotime($event_date));
			$starttime = date('H:i', strtotime($starttime));
			$endtime = date('H:i', strtotime($endtime));
			$tzOffset = $this->offsetON( $event_date )

			$when = $this->service->newWhen();
			$when->startTime 	= "{$event_date}T{$starttime}:00.000{$tzOffset}:00"; 
			$when->endTime 	= "{$event_date}T{$endtime}:00.000{$tzOffset}:00";
	
			$event->when = array($when);
			$newEvent = $this->service->insertEvent($event);
			$eventUri = $newEvent->id->text;

			return $eventUri; 
		}
		catch(Exception $e)
	  	{
	  		error_log($e->getMessage() . ' in add');
	  		return FALSE;
	  	}
	}
	
	public function Delete_gCal_Event( $eventUri )
	{		
		if($eventUri == '' || $eventUri == NULL) return TRUE;		
		try
		{
			$event = $this->service->getCalendarEventEntry($eventUri);
			$event->delete();
			return TRUE;
		}
		
		catch(Exception $e)
	  	{
	  		error_log($e->getMessage() . ' in delete');
	  		return ($eventUri == '' || $eventUri == NULL) ? TRUE : FALSE;
	  	}
	}
	
	public function Edit_gCal_Event($event_date, $starttime, $endtime, $location, $name, $discr, $eventUri)
	{
		if ($this->Delete_gCal_Event( $eventUri ))
		{
			return $this->Add_gCal_Event($event_date, $starttime, $endtime, $location, $name, $discr);
		}
		return FALSE;
	}	
	
	private function offsetON( $date )
	{
		$timeZone = EMAxSTATIC::$TIMEZONE;
		date_default_timezone_set($timeZone);
		$DateTimeObject = new DateTime(date('Y-m-d', strtotime($date)), new DateTimeZone($timeZone));
		$offsetRAW_HOUR = date_offset_get($DateTimeObject) / 60 / 60; //we need to turn that into hours.
		$charOperand = ($offsetRAW_HOUR < 0) ? '-' : '+' ;
		return $charOperand . str_pad(abs($offsetRAW_HOUR), 2, "0", STR_PAD_LEFT);
	}
}
?>
