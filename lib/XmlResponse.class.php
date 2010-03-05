<?php

/**
 * Class that represents a XML response
 */
class XmlResponse extends Response
{
	/**
	 * Constructor method
	 */
	public function __construct ($data)
	{
		parent::__construct ($data);
	}
	
	/**
	 * Implementation of the abstract method in parent class
	 */
	public function build_response ()
	{
		$response = "<?xml version=\"1.0\" encoding=\"UTF-8\"?><response>";
		$response .= "<success>$this->success</success>";
		$response .= "<error_msg>$this->error_msg</error_msg>";
		
		foreach ($this->data as $items)
		{
			$response .= "<item>";
			
			foreach ($items as $key => $value)
			{
				$response .= "<$key>".$value."</$key>";
			}
			
			$response .= "</item>";
		}
		$response .= "</response>";

		return $response;
	}
	
	/**
	 * Outputs the response
	 */
	public function output ()
	{
		header ("Content-Type: text/xml");
		echo $this->build_response ();
	}
}

?>