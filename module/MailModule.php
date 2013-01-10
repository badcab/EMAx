<?php
require_once('../configure/EMAxSTATIC.php');
class MailModule
{
	
if(EMAxSTATIC::$USE_GOOGLE_EMAIL)
{
	require_once('../module/GoogleMailModule.php');
	$GoogleMail = new GoogleMailModule();
	$GoogleMail->activate($this->getID());
}

if(EMAxSTATIC::$USE_IMAP_EMAIL)
{
	//MHNC will need to go here
}	
	
	
	
	require_once(EMAxSTATIC::$PATH_PHPMAILER);
	$mail = new PHPMailer();
 
	$mail->IsSMTP();  // telling the class to use SMTP
	$mail->Host     = EMAxSTATIC::$smtpServer; // SMTP server
	 
	$mail->SetFrom(EMAxSTATIC::$replyEmail, EMAxSTATIC::$nameOfSender);
	$mail->AddAddress("myfriend@example.net");
	 
	$mail->Subject  = "First PHPMailer Message";
	$mail->Body     = "Hi! \n\n This is my first e-mail sent through PHPMailer.";
	$mail->WordWrap = 50;
	 
	if(!$mail->Send()) 
	{
		echo 'Message was not sent.';
		echo 'Mailer error: ' . $mail->ErrorInfo;
	} 
	else 
	{
		echo 'Message has been sent.';
	}
}
?>