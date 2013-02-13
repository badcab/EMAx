<?php
require_once('../model/EventModel.php');
require_once('../configure/EMAxSTATIC.php');
class EmailModule
{
	private $Event;
	
	function __construct($eventID)
	{
		$this->Event = new EventModel((int)$eventID);
	}
	
	public function activate()
	{
		$Event = $this->Event;
		$Person = $Event->getPerson();
		$Organization = $Event->getOrganization();
		
		global $CONFIG;
		date_default_timezone_set($CONFIG->TIMEZONE);
		
		$eventDate = date('l, F jS', strtotime($Event->getstartTime()));	
		$eventTime = date("g:i a", strtotime($Event->getstartTime()));	
		
		$roomLocation = $Event->getRoomLocation()->getRoomLocation();
		$attendance = $Event->getattendance();
		$cost = $Event->getcost();
		
		$eventTypeCost = '';
		
		$links = EMAxSTATIC::$EMAIL_LINK_ALL;

		$orgName = $CONFIG->NAME_OF_ORG;
		$orgPhone = EMAxSTATIC::$PHONE_OF_ORG;
		$orgEmail = $CONFIG->EMAIL_OF_ORG;
		$orgAddress = $CONFIG->ADDRESS_OF_ORG;
		$emailAddress = ( $Person->getemailAddress() ) ? $Person->getemailAddress() : $Organization->getemailAddress() ; 
		$emailSubjectLine = "Conformation of Event at {$orgName} on {$eventDate}";	
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
			$eventTypeCost = 'for a total cost of $' . number_format($cost, 2, '.', '');
			$links = array_merge($links, EMAxSTATIC::$EMAIL_LINK_ROOM_RESERVATION);
		}
		else    
		{
			//is not a room reservation
			$eventTypeCost = 'for a total cost of $' . number_format($attendance * $cost, 2, '.', '') . ' assuming everyone comes';
			$links = array_merge($links, EMAxSTATIC::$EMAIL_LINK_FEILD_TRIP_ALL);
		}

		$season = (int)date('m', strtotime($Event->getstartTime()));
		
		if($season >= $october || $season <= $febuary) 
		{
			$links = array_merge($links, EMAxSTATIC::$EMAIL_LINK_FEILD_TRIP_WINTER);
			$emailBodySeason = $CONFIG->EMAIL_BODY_ADD_ON_WINTER;
		}
		elseif($season >= $march && $season <= $may) 
		{
			$links = array_merge($links, EMAxSTATIC::$EMAIL_LINK_FEILD_TRIP_SPRING);
			$emailBodySeason = $CONFIG->EMAIL_BODY_ADD_ON_SPRING;
		}		
		elseif($season >= $june && $season <= $september) 
		{	
			$links = array_merge($links, EMAxSTATIC::$EMAIL_LINK_FEILD_TRIP_SUMMER);
			$emailBodySeason = $CONFIG->EMAIL_BODY_ADD_ON_SUMMER;
		}
		else
		{
			$links = array_merge($links, EMAxSTATIC::$EMAIL_LINK_FEILD_TRIP_FALL);
			$emailBodySeason = $CONFIG->EMAIL_BODY_ADD_ON_FALL;
		}
		
		$linkEmailBody = '';
		
		foreach($links as $link)
		{
			$linkEmailBody .= "<li> {$link} </li>";
		}
		$email = array(
			'body' => '',
			'subject' => $emailSubjectLine,
			'address' => $emailAddress,		
		);
		
		$email['body'] = "
			<p>
			To {$Person->getfName()} {$Person->getlName()},
			</p>
			
			<p>
			This email is confirmation that you have successfully booked an event at the 
			{$orgName} on {$eventDate} at {$eventTime} in the {$roomLocation} {$eventTypeCost}.
			</p>	
			
			<p>
			{$emailBodySeason}
			</p>	
			
			<p>
			Here are some documents you will need for your event to be successful: 
			</p>	

			<ul>
			{$linkEmailBody}
			</ul>
			
			<p>
			Thank you for your interest in {$orgName} we look forward to serving you
			</p>
			
			<sub> {$orgPhone} | {$orgAddress} </sub>	
			
		";
		return $email;
	}
}
?>