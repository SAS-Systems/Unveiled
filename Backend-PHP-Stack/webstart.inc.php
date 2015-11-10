<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
set_time_limit ( 999 );

//testchange

///////////////////////////////////////////////////////////////////////////
//Config File

//require_once( __DIR__.DIRECTORY_SEPARATOR.'config.inc.php' );
require_once( '../../../config.inc.php' );

///////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////
//MySQLi Connect

//MySQL Verbindung aufbauen
$dbConn = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

if($dbConn->connect_errno > 0){
	die( 'MySQL Error: ' . $dbConn->connect_error . ']' );
}

///////////////////////////////////////////////////////////////////////////


///////////////////////////////////////////////////////////////////////////
//Klasse laden

require_once( __DIR__.DIRECTORY_SEPARATOR.'class'.DIRECTORY_SEPARATOR.'file.class.php' );

require_once( __DIR__.DIRECTORY_SEPARATOR.'class'.DIRECTORY_SEPARATOR.'video_file.class.php' );

require_once( __DIR__.DIRECTORY_SEPARATOR.'class'.DIRECTORY_SEPARATOR.'picture_file.class.php' );

require_once( __DIR__.DIRECTORY_SEPARATOR.'class'.DIRECTORY_SEPARATOR.'message.class.php' );

require_once( __DIR__.DIRECTORY_SEPARATOR.'class'.DIRECTORY_SEPARATOR.'user.class.php' );

require_once( __DIR__.DIRECTORY_SEPARATOR.'class'.DIRECTORY_SEPARATOR.'error_log.class.php' );

///////////////////////////////////////////////////////////////////////////


///////////////////////////////////////////////////////////////////////////
//Global Functions

require_once( __DIR__.DIRECTORY_SEPARATOR.'class'.DIRECTORY_SEPARATOR.'globalfunctions.function.php' );

///////////////////////////////////////////////////////////////////////////
