<?php

class JsonResponse extends Response
{
	public function __construct ($data)
	{
		parent::__construct ($data);
	}
	
	public function build_response ()
	{
		return json_encode ($this->data);
	}
	
	public function output ()
	{
		header ("Content-Type: text/json");
		echo $this->build_response ();
	}
}

?>