<?php
class EMAxSTATIC
{
	public static $AUTH_LEVEL_LOGIN = 0;
	public static $AUTH_LEVEL_ADMIN = 1;
	
	public static $IMPOSSIBLE_PK_NUMBER = 0;
	public static $IMPOSSIBLE_ZIP_CODE = '00000';
	public static $IMPOSSIBLE_CITY = 'UNKNOWN';
	
	public static $FIELD_TRIP_EVENT = 0;
	public static $ROOM_RESERVATION_NON_PROFIT = 1;
	public static $ROOM_RESERVATION_FOR_PROFIT = 2;
	public static $PUBLIC_PROGRAM_EVENT = 3;
	
	public static $db_host = '127.0.0.1';
	public static $db_user = 'root';
	public static $db_name = 'EMAx2';
	public static $db_password = 'your-new-password';
	
	public static $passwordSalt = 'ghger67irs6&^Sfukl5324f6cfja';
	
	/*
we will need another table for the links
TYPE(int) and LINK(varchar)
a module or _model will have to be set up for the fetching
	*/
	
	public static $EMAIL_LINK_ALL = array(
		'this is a link All http://google.com',
		'this is a link more all http://google.com',
	);
	
	public static $EMAIL_LINK_FEILD_TRIP_ALL = array(
		'this is a link FT http://google.com',
	);
	
	public static $EMAIL_LINK_ROOM_RESERVATION = array(
		'this is a link RR http://google.com',
	);
	
	public static $EMAIL_LINK_FEILD_TRIP_SUMMER = array(
		'this is a link summer http://google.com',
	);
	
	public static $EMAIL_LINK_FEILD_TRIP_FALL = array(
		'this is a link Fall http://google.com',
	);
	
	public static $EMAIL_LINK_FEILD_TRIP_WINTER = array(
		'this is a link winter http://google.com',
	);
	
	public static $EMAIL_LINK_FEILD_TRIP_SPRING = array(
		'this is a link spring http://google.com',
	);
}

class CONFIG
{
	function __construct()
   {
	  	if(!isset($GLOBALS['EMAxCONFIG']))
		{		
			require_once( dirname(__FILE__) . '/../model/CONFIG_Model.php');
			$Config = new CONFIG_Model(EMAxSTATIC::$db_host, EMAxSTATIC::$db_name, EMAxSTATIC::$db_user, EMAxSTATIC::$db_password);
			$GLOBALS['EMAxCONFIG'] = $Config->getAll();
		}
 	
		$this->TIMEZONE = $GLOBALS['EMAxCONFIG']['TIMEZONE'];
		$this->COUNTY = $GLOBALS['EMAxCONFIG']['COUNTY'];
		$this->DEFAULT_STATE = $GLOBALS['EMAxCONFIG']['DEFAULT_STATE'];
		$this->AREA_CODE = $GLOBALS['EMAxCONFIG']['AREA_CODE'];
		$this->NAME_OF_ORG = $GLOBALS['EMAxCONFIG']['NAME_OF_ORG'];
		$this->PHONE_OF_ORG = $GLOBALS['EMAxCONFIG']['PHONE_OF_ORG'];
		$this->EMAIL_OF_ORG = $GLOBALS['EMAxCONFIG']['EMAIL_OF_ORG'];
		$this->ADDRESS_OF_ORG = $GLOBALS['EMAxCONFIG']['ADDRESS_OF_ORG'];
		$this->HOURS_BEFORE_EXTRA_CHARGE = (int)$GLOBALS['EMAxCONFIG']['HOURS_BEFORE_EXTRA_CHARGE'];
		$this->USE_GOOGLE_CAL = (int)$GLOBALS['EMAxCONFIG']['USE_GOOGLE_CAL'];//is a bool
		$this->USE_SSL = (int)$GLOBALS['EMAxCONFIG']['USE_SSL'];//is a bool
		$this->PATH_ZEND = $GLOBALS['EMAxCONFIG']['PATH_ZEND'];
		$this->PATH_JQUERY = $GLOBALS['EMAxCONFIG']['PATH_JQUERY'];
		$this->PATH_JQUERY_UI = $GLOBALS['EMAxCONFIG']['PATH_JQUERY_UI'];
		$this->PATH_JQUERY_UI_CSS = $GLOBALS['EMAxCONFIG']['PATH_JQUERY_UI_CSS'];
		$this->googleUserName = $GLOBALS['EMAxCONFIG']['googleUserName'];
		$this->googlePassword = $GLOBALS['EMAxCONFIG']['googlePassword'];
		$this->EMAIL_BODY_ADD_ON_SUMMER = $GLOBALS['EMAxCONFIG']['EMAIL_BODY_ADD_ON_SUMMER'];
		$this->EMAIL_BODY_ADD_ON_FALL = $GLOBALS['EMAxCONFIG']['EMAIL_BODY_ADD_ON_FALL'];
		$this->EMAIL_BODY_ADD_ON_WINTER = $GLOBALS['EMAxCONFIG']['EMAIL_BODY_ADD_ON_WINTER'];
		$this->EMAIL_BODY_ADD_ON_SPRING = $GLOBALS['EMAxCONFIG']['EMAIL_BODY_ADD_ON_SPRING'];
		$this->MINIMUM_FIELD_TRIP_INCOME = (double)$GLOBALS['EMAxCONFIG']['MINIMUM_FIELD_TRIP_INCOME'];
		$this->SURCHARGE_FOR_OUT_OF_COUNTY = (double)$GLOBALS['EMAxCONFIG']['SURCHARGE_FOR_OUT_OF_COUNTY'];
   }	
   
   public static $TIMEZONE;
	public static $COUNTY;
	public static $DEFAULT_STATE;
	public static $AREA_CODE;
	public static $NAME_OF_ORG;
	public static $PHONE_OF_ORG;
	public static $EMAIL_OF_ORG;
	public static $ADDRESS_OF_ORG;	
	public static $HOURS_BEFORE_EXTRA_CHARGE;
	public static $USE_GOOGLE_CAL;
	public static $USE_SSL;
	public static $PATH_ZEND;
	public static $PATH_JQUERY;
	public static $PATH_JQUERY_UI;
	public static $PATH_JQUERY_UI_CSS;
	public static $googleUserName;
	public static $googlePassword;
	public static $EMAIL_BODY_ADD_ON_SUMMER;
	public static $EMAIL_BODY_ADD_ON_FALL;
	public static $EMAIL_BODY_ADD_ON_WINTER;
	public static $EMAIL_BODY_ADD_ON_SPRING;
	public static $MINIMUM_FIELD_TRIP_INCOME;
	public static $SURCHARGE_FOR_OUT_OF_COUNTY;
}
$CONFIG = new CONFIG();
?>
