<?php

define('EMAIL_ADMIN_ORDER','shalom@exceedit.co.uk');
//define('EMAIL_ADMIN_ORDER', 'admin@achisomoch.org');
define('EMAIL_ADMIN_FROM', EMAIL_ADMIN_ORDER);
//define('EMAIL_ADMIN_CONTACT', 'admin@achisomoch.org');
define('EMAIL_ADMIN_CONTACT',EMAIL_ADMIN_ORDER);

/**
  achisomoch
  achisomoch
  ach459

  http://www.bsnet.co.uk/mpa/
 * */
/**
if ($_SERVER['HTTP_HOST'] == 'beta-webserver.com' || $_SERVER['HTTP_HOST'] == 'www.beta-webserver.com') {
    define("DB_DATABASE", "betawebs_phpaac");
    define("DB_HOST", "localhost");
    define("DB_USERNAME", "betawebs_phpaac");
    define("DB_PASSWORD", "G-M&1{;9TKp7");
    define("DB_PCONNECT", true);

    define("SITE_ROOT", "/tech/betaphp/aac-donate/");
    //define("ROOT_DIR",realpath('.'). "/"); 
    define("ROOT_WWW", "http://" . $_SERVER['HTTP_HOST'] . "/tech/betaphp/aac-donate/");

    //ini_set('error_reporting',' E_ERROR ¦ E_WARNING');
    define('ALLOWED_IP_ADDRESS', '1.22.229.47,122.170.166.203,150.129.166.25');
} else {

    define('DB_HOST', 'localhost');
    define('DB_USERNAME', "root");
    define('DB_PASSWORD', "");
    define('DB_DATABASE', 'php_achisomoch');
    define("DB_PCONNECT", true);

    define("SITE_ROOT", "/xampp/projects/aac-donate/");
    define("ROOT_WWW", "http://" . $_SERVER['HTTP_HOST'] . "/xampp/projects/aac-donate/");

    define('ALLOWED_IP_ADDRESS', $_SERVER['REMOTE_ADDR']);
}
**/

 define('DB_HOST','localhost');
  define('DB_USERNAME','devdb_achisomoch');
  define('DB_PASSWORD','s0Z&pz09');
  define('DB_DATABASE','devdb_achisomoch'); 

define('SMTP_ENABLED', 1);
define('SMTP_SERVER', 'mail.premium2.uk.plesk-server.com');
define('SMTP_USERNAME', 'mail@clients.achisomoch.org');
define('SMTP_PASSWORD', 'achiMailer59');


define('SITE_ROOT','/achisomoch/');
define('SSL_ENABLED', 0);

define('NIS_EXRATE', 5.74);
define('USD_EXRATE', 1.46);
define('EUR_EXRATE', 1.34);

//ini_set('error_reporting','0');
//error_reporting(0);
//ini_set('display_errors', 'Off');

define('RECORD_FOLDER', 'records/');
date_default_timezone_set('Europe/London');

if (SSL_ENABLED && !$_SERVER['HTTPS']) {
    //$url = 'https://'.$_SERVER['HTTP_HOST'].''.$_SERVER['REQUEST_URI'];//.'?'.$_SERVER['QUERY_STRING'];  
    $url = "https://" . $_SERVER['HTTP_HOST'] . "/xampp/projects/aac-donate/"; //.'?'.$_SERVER['QUERY_STRING'];                
    header("location: $url");
    exit;
}
?>