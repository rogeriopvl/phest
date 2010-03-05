<?php

/**
 * Main class that operates the REST server
 */
class RestServer
{
	private $request_handler;
	
	/**
	 * Constructor method
	 */
	public function __construct ()
	{
		$this->request_handler = new RequestHandler ();
	}
	
	/**
	 * Starts the REST server
	 */
	public function start_server ()
	{
		$res = $this->request_handler->process_request ();

		$response = new XMLResponse ($res);
		$response->output ();
	}
}

?>