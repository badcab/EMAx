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
		
$eventDate;	
$eventTime;	
		
//list of grades and options for event
//figure out the relevent links to display below		
		
		$emailAddress = ( $Person->getemailAddress() ) ? $Person->getemailAddress() : $Organization->getemailAddress() ; 		
		
//some logic if no email address to be found we need do something about that?
		
		$email = array(
			'body' => '',
			'subject' => 'THIS IS THE SUBJECT LINE',
			'address' => $emailAddress,		
		);
		
		$email['body'] = "
			To {$Person->getfName()} {$Person->getlName()},
			
			This email is conformation that you have sucsessfully booked an event at the {EMAxSTATIC::$NAME_OF_ORG} on {$eventDate} at {$eventTime}.		
		";
	
		return $email;
	}
}
?>