<?php

/**
 * Provides an interface for all modular classes
 * Every modular class must implement this interface
 */
abstract class Resource
{
	public function __construct () {}
	
	protected function error ($msg)
	{
		$err = new Error ();
		$out = $err->output ($msg);
		
		return $out;
	}
	
	/**
	 * Returns all info from the class
	 */
	abstract function get_all ();
}

?>