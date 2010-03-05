<?php

require_once ('base.inc.php');

if (AUTH_OPTION === true)
{
	$auth = new Auth (AUTH_TYPE);
}

if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
	$client_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
else
	$client_ip = $_SERVER['REMOTE_ADDR'];

$server = new RestServer();
$server->start_server ();

?>
