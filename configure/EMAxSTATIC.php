<?php
class EMAxSTATIC
{
	public static $TIMEZONE = 'America/Chicago';
	public static $COUNTY = 'Outagamie';
	public static $BASECOST = 0.00;
	public static $DEFAULT_STATE = 'Wisconsin';
	public static $USE_GOOGLE_EMAIL = FALSE;
	public static $USE_GOOGLE_CAL = FALSE;
	public static $USE_IMAP_EMAIL = FALSE;
	public static $USE_SSL = FALSE;
	public static $PATH_ZEND = '../../ZendGdata-1.10.5/library';
	public static $PATH_JQUERY = '//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js';
	public static $PATH_JQUERY_UI = '//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js';
	public static $PATH_JQUERY_UI_CSS = '//ajax.googleapis.com/ajax/libs/jqueryui/1.9.0/themes/base/jquery-ui.css';
	
	public static $db_host = '127.0.0.1';
	public static $db_user = 'root';
	public static $db_name = 'EMAx';
	public static $db_password = 'your-new-password';
	
	public static $passwordSalt = 'ghger67irs6&^Sfukl5324f6cfja';
	
	public static $googleUserName = '';
	public static $googlePassword = '';
	
	public static $iMapPassword = '';
	public static $iMapServer = '';
	public static $iMapUserName = '';	
	
	public static $nameOfSender = '';
	public static $replyEmail = '';
}
?>
