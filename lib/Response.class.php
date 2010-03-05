<?php

/**
 * Abstract class that creates the response interface
 */
abstract class Response
{
	protected $data;
	protected $success;
	protected $error_msg;
	
	/**
	 * Constructor method
	 * @param string $data the data to be outputted has a response
	 */
	public function __construct ($data)
	{
		$this->success = $data['success'];
		$this->error_msg = $data['error_msg'];
		
		unset ($data['success']);
		unset ($data['error_msg']);
		
		$this->data = $data;
	}
	
	/**
	 * Builds a response
	 */
	abstract function build_response ();
	
	/**
	 * Outputs the response
	 */
	abstract function output ();
}

?>