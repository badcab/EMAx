<?php
class EMAxSTATIC
{
	public static $TIMEZONE = 'America/Chicago';
	public static $COUNTY = 'Outagamie';
	public static $BASECOST = 0.00;
	public static $DEFAULT_STATE = 'Wisconsin';
	public static $AREA_CODE = '920';
	public static $NAME_OF_ORG = 'Mosquito Hill Nature Center';
	public static $PHONE_OF_ORG = '(920) 779-6433';
	public static $EMAIL_OF_ORG = '';
	public static $ADDRESS_OF_ORG = 'N3880 County Road Nc, New London, WI 54961';
	
	public static $FEILD_TRIP_EVENT = 0;
	public static $ROOM_RESERVATION_NON_PROFIT = 1;
	public static $ROOM_RESERVATION_FOR_PROFIT = 2;
	
	public static $USE__EMAIL = FALSE; //I can likely get rid of this for now
		public static $USE_GOOGLE_EMAIL = FALSE;
		public static $USE_SMTP_EMAIL = FALSE;
		public static $USE_EXCHANGE_EMAIL = FALSE;
	
	public static $USE_GOOGLE_CAL = FALSE;
	public static $USE_SSL = FALSE;
	public static $PATH_ZEND = '../../ZendGdata-1.10.5/library';
	public static $PATH_JQUERY = '//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js';
	public static $PATH_JQUERY_UI = '//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js';
	public static $PATH_JQUERY_UI_CSS = '//ajax.googleapis.com/ajax/libs/jqueryui/1.9.0/themes/base/jquery-ui.css';
	public static $PATH_PHPMAILER = '../../PHPMailer_v5.1/class.phpmailer.php';
	
	public static $db_host = '127.0.0.1';
	public static $db_user = 'root';
	public static $db_name = 'EMAx';
	public static $db_password = 'your-new-password';
	
	public static $passwordSalt = 'ghger67irs6&^Sfukl5324f6cfja';
	
	public static $googleUserName = '';
	public static $googlePassword = '';
	
	public static $smtpPassword = '';
	public static $smtpServer = '';
	public static $smtpUserName = '';	
	
	public static $nameOfSender = '';
	public static $replyEmail = '';
	
	public static $EMAIL_LINK_ALL = array(
		'discription' => 'url',
	);
	
	public static $EMAIL_LINK_FEILD_TRIP_ALL = array(
		'discription' => 'url',
	);
	
	public static $EMAIL_LINK_ROOM_RESERVATION = array(
		'discription' => 'url',
	);
	
	public static $EMAIL_LINK_FEILD_TRIP_SUMMER = array(
		'discription' => 'url',
	);
	
	public static $EMAIL_LINK_FEILD_TRIP_FALL = array(
		'discription' => 'url',
	);
	
	public static $EMAIL_LINK_FEILD_TRIP_WINTER = array(
		'discription' => 'url',
	);
	
	public static $EMAIL_LINK_FEILD_TRIP_SPRING = array(
		'discription' => 'url',
	);
	
	public static $EMAIL_BODY_ADD_ON_SUMMER = '';
	public static $EMAIL_BODY_ADD_ON_FALL = '';
	public static $EMAIL_BODY_ADD_ON_WINTER = '';
	public static $EMAIL_BODY_ADD_ON_SPRING = '';
}
?>
