<?php

require_once (dirname(__FILE__).'/config.inc.php');

/**
 * Auto loads every required class file on instance creation
 */
function __autoload($class_name)
{
	require_once(LIB_FOLDER.'/'.$class_name.'.class.php');
}

?>