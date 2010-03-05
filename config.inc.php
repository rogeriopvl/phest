<?php

/**
 * This is the configuration file for rest9.
 */

// database info to be filled by you
define ('DB_HOST', 'localhost');		// you probably dont need to change this
define ('DB_NAME', 'database_name');	// change to the database name
define ('DB_USER', 'root');				// obvious
define ('DB_PASS', 'root');

// set authentication on(true) or off(false)
define ('AUTH_OPTION', false);

// choose the type of authentication for your API
// you can choose between APIKEY or IP for now
define ('AUTH_TYPE', 'APIKEY');

// the name of the folder to store your classes and helpers
define ('LIB_FOLDER', 'lib');
define ('HELPER_FOLDER', 'helpers');
define ('RESOURCE_FOLDER', 'resources');

// the name of the needed external classes
// the following are default values
define ('DEFAULT_CLASS', 'Welcome');
define ('ERROR_CLASS', 'Error');

// the default method to be called in all classes
// when no method/action is specified
define ('MAIN_METHOD', 'get_all');

// add to the array the name of your classes
// this works as a whitelist
$classes_array = array (
	DEFAULT_CLASS,
	ERROR_CLASS,
	"Example"
);

// add to the array the IP addresses that you want to allow access to the API
// this is only needed if you use APIKEY authentication
$allowed_hosts = array ("127.0.0.1");

?>