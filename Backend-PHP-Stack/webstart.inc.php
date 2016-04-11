<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
set_time_limit(999);

///////////////////////////////////////////////////////////////////////////
//Config File

//require_once( __DIR__.DIRECTORY_SEPARATOR.'config.inc.php' );
require_once(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config.inc.php');

///////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////
//MySQLi Connect

//MySQL Verbindung aufbauen
$dbConn = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

if ($dbConn->connect_errno > 0) {
    die('MySQL Error: ' . $dbConn->connect_error . ']');
}

///////////////////////////////////////////////////////////////////////////


///////////////////////////////////////////////////////////////////////////
//Klasse laden

require_once(__DIR__ . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . 'file.class.php');

require_once(__DIR__ . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . 'video_file.class.php');

require_once(__DIR__ . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . 'picture_file.class.php');

require_once(__DIR__ . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . 'message.class.php');

require_once(__DIR__ . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . 'user.class.php');

require_once(__DIR__ . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . 'error_log.class.php');

require_once(__DIR__ . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . 'user_permission.class.php');

///////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////
//Slim RESTful API
require_once(__DIR__ . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php');
///////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////
//Global Functions

require_once(__DIR__ . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . 'globalfunctions.function.php');

///////////////////////////////////////////////////////////////////////////


define("SYSTEM_LANGUAGE", "DE");

