<?php
define( 'XNAME',        'option');

define('XPATH_SOURCES',    XPATH.DS.'Sources');
define('XPATH_TEMPLATE',   XPATH.DS.'html'.DS.'common');
define('XPATH_TEMPLATE_FRONT', XPATH.DS.'html');
define('XPATH_CACHE',      XPATH.DS.'cache');

function xload($path, $defaultdir = "", $file_ext = ".php") {
    $default_dir = (empty($defaultdir)) ? XPATH_SOURCES : $defaultdir;
    $path = str_replace(".",DS,$path);
    if (file_exists($default_dir.DS.$path.$file_ext)) {
        //include($default_dir.DS.$path.$file_ext);
        include_once($default_dir.DS.$path.$file_ext);
    }
}
?>