<?php

/**
 * This is the configuration file for rest9.
 */

// database info to be filled by you
define ('DB_HOST', 'localhost');
define ('DB_NAME', '9views_agenda');
define ('DB_USER', 'root');
define ('DB_PASS', 'root');

// choose the type of authentication for your API
// you can choose between APIKEY or IP for now
define ('AUTH_TYPE', 'APIKEY');

// the name of the folder to store your classes
define ('CLASS_FOLDER', 'classes');
define ('HELPER_FOLDER', 'helpers');

// the name of the needed external classes
define ('DEFAULT_CLASS', 'Welcome');
define ('ERROR_CLASS', 'Error');

define ('MAIN_METHOD', 'get_all');

// add to the array the name of your classes that are to work with rest9
$classes_array = array ("Welcome", "Error", "Concertos");

// add to the array the IP addresses that you want to allow access to the API
// this is only needed if you use APIKEY authentication
$allowed_hosts = array ("127.0.0.1");

?>