<?php
class EMAxSTATIC
{
	public static $TIMEZONE = 'America/Chicago';
	public static $COUNTY = 'Outagamie';
	public static $DEFAULT_STATE = 'Wisconsin';
	public static $AREA_CODE = '920';
	public static $NAME_OF_ORG = 'Mosquito Hill Nature Center';
	public static $PHONE_OF_ORG = '(920) 779-6433';
	public static $EMAIL_OF_ORG = '';
	public static $ADDRESS_OF_ORG = 'N3880 County Road Nc, New London, WI 54961';
	
	public static $BASECOST_FEILD_TRIP_IN_COUNTY = 0.00;
	public static $BASECOST_FEILD_TRIP_OUT_OF_COUNTY = 1.00;
	
	public static $BASECOST_NON_PROFIT = 1.00;
	public static $BASECOST_NON_PROFIT_EXTRA_2HR = 1.00;
	
	public static $BASECOST_FOR_PROFIT = 10.00;
	public static $BASECOST_FOR_PROFIT_EXTRA_2HR = 10.00;
		
	public static $AUTH_LEVEL_LOGIN = 0;
	public static $AUTH_LEVEL_ADMIN = 1;
	
	public static $IMPOSSIBLE_PK_NUMBER = 0;
	
	public static $FEILD_TRIP_EVENT = 0;
	public static $ROOM_RESERVATION_NON_PROFIT = 1;
	public static $ROOM_RESERVATION_FOR_PROFIT = 2;
	public static $PUBLIC_PROGRAM_EVENT = 2;

	public static $USE_GOOGLE_CAL = FALSE;
	public static $USE_SSL = FALSE;
	public static $PATH_ZEND = '../../ZendGdata-1.10.5/library';
	public static $PATH_JQUERY = '//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js';
	public static $PATH_JQUERY_UI = '//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js';
	public static $PATH_JQUERY_UI_CSS = '//ajax.googleapis.com/ajax/libs/jqueryui/1.9.0/themes/base/jquery-ui.css';
	
	public static $db_host = '127.0.0.1';
	public static $db_user = 'root';
	public static $db_name = 'EMAx2';
	public static $db_password = 'your-new-password';
	
	public static $passwordSalt = 'ghger67irs6&^Sfukl5324f6cfja';
	
	public static $googleUserName = '';
	public static $googlePassword = '';
	
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
	
	public static $EMAIL_BODY_ADD_ON_SUMMER = 'Summer body';
	public static $EMAIL_BODY_ADD_ON_FALL = 'Fall body';
	public static $EMAIL_BODY_ADD_ON_WINTER = 'Winter body';
	public static $EMAIL_BODY_ADD_ON_SPRING = 'Spring body';
}
?>
