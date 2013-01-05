<?php
class GoogleMailModule
{
	private $username;
	private $password;
	private $nameOfSender;
	private $replyEmail;

	function __construct()
	{
		
		$path = '../ZendGdata-1.10.5/library';
		$oldPath = set_include_path(get_include_path() . PATH_SEPARATOR . $path);		
		require_once ('Zend/Loader.php');
		
		$this->username = EMAxSTATIC::$googleUserName;
		$this->password = EMAxSTATIC::$googlePassword;
		$this->nameOfSender = EMAxSTATIC::$nameOfSender;
		$this->replyEmail = EMAxSTATIC::$replyEmail;
	}

	public function activate( $eventID )
	{
		require_once('../model/EventModel.php');
		$Event = new EventModel($eventID);
		$Organization = $Event->getOrganization();
		$Person = $Event->getPerson();

		if($Person->getemailAddress())
		{	
			$emailBodyText = $this->makeEmaleBodyText($Event, $Organization, $Person);	
		
			$config = array('auth'=>'login', 'username'=>$this->username, 'password'=>$this->password, 'ssl'=>'tls');
			$transport = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $config);//this threw an error for not being foind for some reason
			Zend_Mail::setDefaultTransport($transport);
			$mail = new Zend_Mail();
	
			$mail->setBodyText($emailBodyText);
			$mail->setFrom($this->username, $this->nameOfSender);
			$mail->setReplyTo($this->replyEmail, $this->nameOfSender);
			$mail->addTo($Person->getemailAddress() , $Person->getfName() . ' ' . $Person->getlName() );
			$mail->setSubject($Organization->getOrganization() . ' field trip Confirmation');
			$mail->send($transport);
		}
	}
	
	private function makeEmaleBodyText($Event, $Organization, $Person)
	{
		$result = 'Dear ' . $Person->getfName() . ' ' . $Person->getlName() . "\n\n";
		$result .= 'This is an automated message confirming that you have booked a field trip on ';
		//date $Event->getstartTime()
		$result .= ' at ';
		//time
		$result .= ' for the ';
		$result .=  $Organization->getOrganization();
		$result .= '.' . "\n\n";
		
		$result .= 'You have elected to do the following special activities';
		//options
		$result .= "\n\n";
		
		$result .= 'Our records indicate that you ';
		$result .= ($Event->gethasPaid()) ? 'have paid' : 'have NOT paid' ;
		$result .= '.' . "\n\n";
		
		$result .= '';// closing information and signiture stuff
		
		return $result;
	}
}
?>
