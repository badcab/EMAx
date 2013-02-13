<?php
class EMAxSTATIC
{
	public static $BASECOST_FEILD_TRIP_IN_COUNTY = 0.00; //mark for removal *not db
	public static $BASECOST_FEILD_TRIP_OUT_OF_COUNTY = 1.00; //mark for removal *not db
	
	public static $BASECOST_NON_PROFIT = 1.00; //mark for removal *not db
	public static $BASECOST_NON_PROFIT_EXTRA_2HR = 1.00; //mark for removal *not db
	
	public static $BASECOST_FOR_PROFIT = 10.00; //mark for removal *not db
	public static $BASECOST_FOR_PROFIT_EXTRA_2HR = 10.00; //mark for removal *not db
		
	public static $AUTH_LEVEL_LOGIN = 0;
	public static $AUTH_LEVEL_ADMIN = 1;
	
	public static $IMPOSSIBLE_PK_NUMBER = 0;
	
	public static $FIELD_TRIP_EVENT = 0;
	public static $ROOM_RESERVATION_NON_PROFIT = 1;
	public static $ROOM_RESERVATION_FOR_PROFIT = 2;
	public static $PUBLIC_PROGRAM_EVENT = 3;
	
	public static $db_host = '127.0.0.1';
	public static $db_user = 'root';
	public static $db_name = 'EMAx2';
	public static $db_password = 'your-new-password';
	
	public static $passwordSalt = 'ghger67irs6&^Sfukl5324f6cfja';
	
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
   	if(!isset($_SESSION['EMAxCONFIG']))
		{		
			require_once(get_include_path() . '/model/CONFIG_Model.php');
			$Config = new CONFIG_Model(EMAxSTATIC::$db_host, EMAxSTATIC::$db_name, EMAxSTATIC::$db_user, EMAxSTATIC::$db_password);
			$_SESSION['EMAxCONFIG'] = $Config->getAll();
		}
 	
		$this->TIMEZONE = $_SESSION['EMAxCONFIG']['TIMEZONE'];
		$this->COUNTY = $_SESSION['EMAxCONFIG']['COUNTY'];
		$this->DEFAULT_STATE = $_SESSION['EMAxCONFIG']['DEFAULT_STATE'];
		$this->AREA_CODE = $_SESSION['EMAxCONFIG']['AREA_CODE'];
		$this->NAME_OF_ORG = $_SESSION['EMAxCONFIG']['NAME_OF_ORG'];
		$this->PHONE_OF_ORG = $_SESSION['EMAxCONFIG']['PHONE_OF_ORG'];
		$this->EMAIL_OF_ORG = $_SESSION['EMAxCONFIG']['EMAIL_OF_ORG'];
		$this->ADDRESS_OF_ORG = $_SESSION['EMAxCONFIG']['ADDRESS_OF_ORG'];
		$this->HOURS_BEFORE_EXTRA_CHARGE = (int)$_SESSION['EMAxCONFIG']['HOURS_BEFORE_EXTRA_CHARGE'];
		$this->USE_GOOGLE_CAL = (int)$_SESSION['EMAxCONFIG']['USE_GOOGLE_CAL'];//is a bool
		$this->USE_SSL = (int)$_SESSION['EMAxCONFIG']['USE_SSL'];//is a bool
		$this->PATH_ZEND = $_SESSION['EMAxCONFIG']['PATH_ZEND'];
		$this->PATH_JQUERY = $_SESSION['EMAxCONFIG']['PATH_JQUERY'];
		$this->PATH_JQUERY_UI = $_SESSION['EMAxCONFIG']['PATH_JQUERY_UI'];
		$this->PATH_JQUERY_UI_CSS = $_SESSION['EMAxCONFIG']['PATH_JQUERY_UI_CSS'];
		$this->googleUserName = $_SESSION['EMAxCONFIG']['googleUserName'];
		$this->googlePassword = $_SESSION['EMAxCONFIG']['googlePassword'];
		$this->EMAIL_BODY_ADD_ON_SUMMER = $_SESSION['EMAxCONFIG']['EMAIL_BODY_ADD_ON_SUMMER'];
		$this->EMAIL_BODY_ADD_ON_FALL = $_SESSION['EMAxCONFIG']['EMAIL_BODY_ADD_ON_FALL'];
		$this->EMAIL_BODY_ADD_ON_WINTER = $_SESSION['EMAxCONFIG']['EMAIL_BODY_ADD_ON_WINTER'];
		$this->EMAIL_BODY_ADD_ON_SPRING = $_SESSION['EMAxCONFIG']['EMAIL_BODY_ADD_ON_SPRING'];
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
}
$CONFIG = new CONFIG();
?>
