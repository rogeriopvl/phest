<?php

class Error extends Resource
{
	public function __construct () {}
	
	/**
	 * Returns and error message
	 */
	public function get_all ()
	{
		$res = array (
			0 => array(),
			"success" => "false",
			"error_msg" => "Your request is invalid.",
		);
		
		return $res;
	}
	
	public function output ($msg)
	{
		$res = array (
			0 => array(),
			"success" => "false",
			"error_msg" => $msg,
		);
		
		return $res;
	}
}
?>