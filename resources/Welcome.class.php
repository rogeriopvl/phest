<?php

class Welcome extends Resource
{
	public function __construct () {}
	
	/**
	 * Returns a default message
	 */
	public function get_all ()
	{
		$res = array (
			0 => array (
				"message" => "Connection to this API was successful.",
			),
			"success" => "true",
			"error_msg" => "",
		);
		
		return $res;
	}
}
?>