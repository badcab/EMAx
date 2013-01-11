<?php
require_once('../configure/EMAxSTATIC.php');
class MailModule
{
	private $mail;
	private $EventID;
	
	function __construct($EventID)
	{
		$this->EventID = (int)$EventID;
		if(EMAxSTATIC::$USE_GOOGLE_EMAIL)
		{
			require_once('../module/GoogleMailModule.php');
			$this->mail = new GoogleMailModule();
		}
		
		elseif(EMAxSTATIC::$USE_SMTP_EMAIL)
		{
			require_once(EMAxSTATIC::$PATH_PHPMAILER);
			$this->mail = new PHPMailer();
		}	
		
		elseif(EMAxSTATIC::$USE_EXCHANGE_EMAIL)
		{
			require_once(EMAxSTATIC::$PATH_PHPMAILER);
		}
	}
	
	function activate()
	{
		if(EMAxSTATIC::$USE_GOOGLE_EMAIL)
		{
			$this->mail->activate($this->EventID);			
		}
		
		elseif(EMAxSTATIC::$USE_SMTP_EMAIL) 
		{
/*	$this->mail->IsSMTP();  // telling the class to use SMTP
	$this->mail->Host     = EMAxSTATIC::$smtpServer; // SMTP server
	 
	$this->mail->SetFrom(EMAxSTATIC::$replyEmail, EMAxSTATIC::$nameOfSender);
	$this->mail->AddAddress("myfriend@example.net");
	 
	$this->mail->Subject  = "First PHPMailer Message";
	$this->mail->Body     = "Hi! \n\n This is my first e-mail sent through PHPMailer.";
	$this->mail->WordWrap = 50;
	 
	if(!$this->mail->Send()) 
	{
		echo 'Message was not sent.';
		echo 'Mailer error: ' . $this->mail->ErrorInfo;
	} 
	else 
	{
		echo 'Message has been sent.';
	}
*/			
		}
		
		elseif(EMAxSTATIC::$USE_EXCHANGE_EMAIL) 
		{
			
		}
	}
}
?>