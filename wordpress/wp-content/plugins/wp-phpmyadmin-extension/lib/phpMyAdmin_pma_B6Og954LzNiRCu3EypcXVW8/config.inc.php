<?php

if(!defined("ABSPATH")) exit("direct_access_forbidden");

include("_session_temp.php");
if( ( empty($_COOKIE[$sess_vars["name"]]) ||  $_COOKIE[$sess_vars["name"]] !=  $sess_vars["value"]) )	{
	exit('Go back (to the last page from where you tried to enter this page) and refresh that page, and then click  "enter PhpMyAdmin" button again. If you still have problems, open ticket at <a href="https://wordpress.org/support/plugin/wp-phpmyadmin-extension/">Support pages</a>, probably something breaks a normal page-load in dashboard.');
}

$i = 0;

$i++;
$cfg['Servers'][$i]['host'] 			= '127.0.0.1';
$cfg['Servers'][$i]['AllowNoPassword']	= true;   // true/false
$cfg['blowfish_secret']					= ',0%F3;@]eZg+V>Ti2}i_,S|!*x?!v.`<' ;  // i.e. '$b~`lnkwm>^^jNUEE;(4xB$L\'b?."\'o9' 
$cfg['DefaultLang']						= 'en';		// 'en'
$cfg['Servers'][$i]['only_db']			= array('Pelostop') ;    //i.e. array('db1', 'db2') Show only listed databases
//$cfg['LoginCookieValidity']			= 14400;

// fixed vars   -- at this moment, not needed
//$cfg['AllowThirdPartyFraming'] = true;
//header('X-Frame-Options: SAMEORIGIN' );

// disable caching of pages
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");  



$cfg['ServerDefault'] = 1;  // If you have more than one server configured, you can set $cfg['ServerDefault'] to any one of them to auto-connect to that server when phpMyAdmin is started,  or set it to 0 to be given a list of servers without logging in If you have only one server configured, $cfg['ServerDefault'] *MUST* be  set to that server. 
$cfg['UploadDir'] = '';  //'Upload directoryDocumentation Directory on server where you can upload files for import.';
$cfg['SaveDir'] = '';  // 'Save directoryDocumentation Directory where exports can be saved on server';

//$cfg['Servers'][$i]['port']		= 10222;
//$cfg['Servers'][$i]['ssl']		= true;  //Compress connection to MySQL server.
//$cfg['Servers'][$i]['compress']	= false;
$cfg['Servers'][$i]['auth_type']	= 'cookie';
//$cfg['Servers'][$i]['user']		= 'User for config authDocumentation Leave empty if not using config auth.';
//$cfg['Servers'][$i]['password']	= 'Password for config authDocumentation Leave empty if not using config auth.';
$cfg['Servers'][$i]['DisableIS']	= true;  //disable information schema
//$cfg['Servers'][$i]['SessionTimeZone']= 'Session timezoneDocumentation Sets the effective timezone; possibly different than the one from your database server';
//$cfg['Servers'][$i]['controlhost']= 'Control host';
//$cfg['Servers'][$i]['controlport']= 'Control port';
//$cfg['Servers'][$i]['controluser']= 'Control user';
//$cfg['Servers'][$i]['controlpass']= 'Control user password';
$cfg['RetainQueryBox'] 				= true;
$cfg['ShowDbStructureCharset'] 		= true;
$cfg['NavigationTreeEnableGrouping']= false; //disable grouping
$cfg['MaxNavigationItems']			= 200;	// # of tables to show in left table list
$cfg['FirstLevelNavigationItems']	= 200;	// same
//$cfg['AllowArbitraryServer']		= true;
//$cfg['ArbitraryServerRegexp']		= 'Restrict login to MySQL serverDocumentation Restricts the MySQL servers the user can enter when a login to an arbitrary MySQL server is enabled by matching the IP or hostname of the MySQL server to the given regular expression.';

?>