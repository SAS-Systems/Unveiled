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

require_once(__DIR__ . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . 'email_service.class.php');

require_once(__DIR__ . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . 'dao' . DIRECTORY_SEPARATOR . 'dao.interface.php');

require_once(__DIR__ . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . 'dao' . DIRECTORY_SEPARATOR . 'dao_file.interface.php');

require_once(__DIR__ . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . 'dao' . DIRECTORY_SEPARATOR . 'dao_message.interface.php');

require_once(__DIR__ . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . 'dao' . DIRECTORY_SEPARATOR . 'dao_user.interface.php');

require_once(__DIR__ . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . 'dao' . DIRECTORY_SEPARATOR . 'dao_video.class.php');

require_once(__DIR__ . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . 'dao' . DIRECTORY_SEPARATOR . 'dao_message.class.php');

require_once(__DIR__ . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . 'dao' . DIRECTORY_SEPARATOR . 'dao_user.class.php');


///////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////
//Slim RESTful API
require_once(__DIR__ . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php');
///////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////
//Global Functions

require_once(__DIR__ . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . 'globalfunctions.function.php');

///////////////////////////////////////////////////////////////////////////


///////////////////////////////////////////////////////////////////////////
//PHP Mailer

require_once(__DIR__ . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'PHPMailer' . DIRECTORY_SEPARATOR .  'class.phpmailer.php');
require_once(__DIR__ . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'PHPMailer' . DIRECTORY_SEPARATOR .  'class.smtp.php');
///////////////////////////////////////////////////////////////////////////

define("SYSTEM_LANGUAGE", "EN");

