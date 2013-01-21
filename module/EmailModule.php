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
		
		$emailAddress = ( $Person->getemailAddress() ) ? $Person->getemailAddress() : $Organization->getemailAddress() ; 		
		
//some logic if no email address to be found we need do something about that?
		
		$email = array(
			'body' => '',
			'address' => $emailAddress,		
		);
		
		$email['body'] = 'this is the email body';
		//will need to pull needed info into the letter, all body work should be done in the static
		
		return $email;
	}
}
?>