<?php
error_reporting(~E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED & ~E_STRICT);

@date_default_timezone_set('Europe/London');

define('XPATH', dirname(__FILE__) );
    
define('X_TEMPLATE', "default" );
define( 'DS', DIRECTORY_SEPARATOR );
require_once ( XPATH.DS.'Sources'.DS.'defines.php' );

xload("class.lib.main");
xload("class.lib.auth");
xload("functions");
xload("mainframe");

$mainframe = new mainframe;

$mainframe->run();
?>