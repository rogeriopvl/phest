<?php

require_once ('config.inc.php');
require_once (LIB_FOLDER.'/rest.php');
require_once (LIB_FOLDER.'/Auth.class.php');

$auth = new Auth (AUTH_TYPE);

if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
	$client_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
else
	$client_ip = $_SERVER['REMOTE_ADDR'];


//print_r($_REQUEST);die;
$server = new REST_Server();
$server->start_server ();

?>
