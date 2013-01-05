<?php 
class GoogleCalanderModule
{
	private $service;
	private $client;
	
	function __construct()
	{
		require('../configure/google_connect.php');
		$path = '../ZendGdata-1.10.5/library';
		$oldPath = set_include_path(get_include_path() . PATH_SEPARATOR . $path);
		
		require_once ('Zend/Loader.php');
		Zend_Loader::loadClass('Zend_Gdata');
		Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
		Zend_Loader::loadClass('Zend_Gdata_Calendar');

		try 
		{
   		$this->client = Zend_Gdata_ClientLogin::getHttpClient($googleUserName, $googlePassword, 'cl');
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
//    			foreach($listFeed as $feed)
//error_log( $feed . " is the feed");
		} 
		catch (Zend_Gdata_App_Exception $e) 
		{
//error_log( "Error: " . $e->getMessage() );
		}
	}
	
	public function activate()
	{
		/* Does nothing, only here for consistency */
	}
	
	private function get_timezone_offset($remote_tz, $origin_tz = null) 
	{
	   if($origin_tz === null) 
	   {
	      $origin_tz = 'Etc/GMT';
	   }
		$origin_dtz = new DateTimeZone($origin_tz);
		$remote_dtz = new DateTimeZone($remote_tz);
		$origin_dt = new DateTime("now", $origin_dtz);
		$remote_dt = new DateTime("now", $remote_dtz);
		$offset = $origin_dtz->getOffset($origin_dt) - $remote_dtz->getOffset($remote_dt);
		$offset = ($offset / 60) / 60;
		if($offset < 10)
		{
			return '-0' . $offset;	
		}
		
		return '-' . $offset;
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
			$tzOffset = $this->get_timezone_offset(date_default_timezone_get()); //timezone auto fix should go here might be 6

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
}
?>
