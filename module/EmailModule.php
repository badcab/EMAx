<?php //MailModule.php can likely be removed
require_once('../model/EventModel.php');
require_once('../configure/EMAxSTATIC.php');
class EmailModule
{
	private $Event;
	
	function __construct((int)$eventID)
	{
		$this->Event = new EventModel($eventID);
	}
	
	public function activate()
	{
		$Event = $this->Event;
		$Person = $Event->getPerson();
		$Organization = $Event->getOrganization();
		
		date_default_timezone_set(EMAxSTATIC::$TIMEZONE);
		
		$eventDate = date('Y-m-d', strtotime($Event->getstartTime()));	
		$eventTime = date("H:i:s", strtotime($Event->getstartTime()));	
		$links = EMAxSTATIC::$EMAIL_LINK_ALL;
//list of grades and options for event
//figure out the relevent links to display below

		$emailAddress = ( $Person->getemailAddress() ) ? $Person->getemailAddress() : $Organization->getemailAddress() ; 
		$emailSubjectLine = "Conformation of Event at {EMAxSTATIC::$NAME_OF_ORG} on {$eventDate}";	
		$emailBodySeason = '';

		$january = 1;
		$febuary = 2;
		$march = 3;
		$may = 5;
		$june = 6;
		$september = 9;
		$october = 10;

		if($Event->getroomReservation()) 
		{
			//is a room reservation
			$links = array_merge($links, EMAxSTATIC::$EMAIL_LINK_ROOM_RESERVATION);
		}
		else 
		{
			//is not a room reservation
			$links = array_merge($links, EMAxSTATIC::$EMAIL_LINK_FEILD_TRIP_ALL);
		}

		$season = (int)date('m', strtotime($Event->getstartTime()));
		
		if($season >= $october || $season <= $febuary) 
		{
			$links = array_merge($links, EMAxSTATIC::$EMAIL_LINK_FEILD_TRIP_WINTER);
			$emailBodySeason = EMAxSTATIC::$EMAIL_BODY_ADD_ON_WINTER;
		}
		elseif($season >= $march && $season <= $may) 
		{
			$links = array_merge($links, EMAxSTATIC::$EMAIL_LINK_FEILD_TRIP_SPRING);
			$emailBodySeason = EMAxSTATIC::$EMAIL_BODY_ADD_ON_SPRING;
		}		
		elseif($season >= $june && $season <= $september) 
		{	
			$links = array_merge($links, EMAxSTATIC::$EMAIL_LINK_FEILD_TRIP_SUMMER);
			$emailBodySeason = EMAxSTATIC::$EMAIL_BODY_ADD_ON_SUMMER;
		}
		else
		{
			$links = array_merge($links, EMAxSTATIC::$EMAIL_LINK_FEILD_TRIP_FALL);
			$emailBodySeason = EMAxSTATIC::$EMAIL_BODY_ADD_ON_FALL;
		}
		
		$linkEmailBody = '';
		
		foreach($links as $link)
		{
			$linkEmailBody .=	key($link) . " {$link} \n";
		}
		$email = array(
			'body' => '',
			'subject' => $emailSubjectLine,
			'address' => $emailAddress,		
		);
		
		$email['body'] = "
			To {$Person->getfName()} {$Person->getlName()},
			
			This email is conformation that you have sucsessfully booked an event at the {EMAxSTATIC::$NAME_OF_ORG} on {$eventDate} at {$eventTime}.	
			{$emailBodySeason}
			Here are some documents you will need for your event to be successful 
			{$linkEmailBody}
			
			Thank you for your interest in {EMAxSTATIC::$NAME_OF_ORG} we look forward to serving you	
		";
	
		return $email;
	}
}
?>