<?php

/**
 * Class that represents a request made to the API
 */
class Request
{
	private $class;
	private $method;
	private $param;
	
	/**
	 * Constructor method
	 */
	public function __construct ($class, $method, $param=NULL)
	{
		$this->class = $class;
		$this->method = $method;
		$this->param = $param;
	}
	
	/**
	 * Returns the uri parameter containing the class
	 * @return the class in uri
	 */
	public function getClass ()
	{
		return $this->class;
	}
	
	/**
	 * Returns the uri parameter containing the method
	 * @return string the method in uri if exists, NULL otherwise
	 */
	public function getMethod ()
	{
		return $this->method;
	}
	
	/**
	 * Returns the uri parameter containing the parameter
	 * @return string the parameter if exists, NULL otherwise
	 */
	public function getParam ()
	{
		return $this->param;
	}
}

?>