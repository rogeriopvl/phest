<?php

/**
 * Class that contains methods to handle requests
 */
class RequestHandler
{	
	/**
	 * Constructor method
	 */
	public function __construct () {}
	
	/**
	 * Extracts the request information from the given URL
	 * @return array associative array with the URL params parsed
	 */
	private function parse_request ()
	{
		global $classes_array; //get better way to do this
		
		$action = strtolower ($_SERVER['REQUEST_METHOD']);
		$uri_params = explode ('/', $_GET['uri']);

		if (!isset ($uri_params[0]) || strlen ($uri_params[0]) < 1)
			$class = DEFAULT_CLASS;
			
		else if (!in_array ($uri_params[0], $classes_array))
			$class = ERROR_CLASS;
		else
			$class = $uri_params[0];
			
		if (!isset ($uri_params[1]) || strlen ($uri_params[1]) < 1)
			$method = NULL;
		else
			$method = $uri_params[1];
		
		if (!isset ($uri_params[2]) || strlen ($uri_params[2]) < 1)
			$param = NULL;
		else
			$param = $uri_params[2];
			
		switch ($action)
		{
			case 'get': $request = new Request ($class, $method, $param); break;
			case 'post': throw new Exception ("POST: operation currently not supported."); break;
			case 'put': throw new Exception ("PUT: operation currently not supported."); break;
			case 'delete': throw new Exception ("DELETE: operation currently not supported."); break;
		}

		return $request;
	}
	
	/**
	 * Processes the request. Should only be used after
	 */
	public function process_request ()
	{
		$req = $this->parse_request ();
		$this->load_classes ();
		
		$classname = $req->getClass();
		$obj = new $classname;

		if ($req->getMethod () === NULL)
			$methodname = MAIN_METHOD;
		
		else if (!method_exists($obj, "get_".$req->getMethod()))
		{
			$classname = ERROR_CLASS;
			$obj = new $classname;
			$methodname = MAIN_METHOD;
		}
		else
			$methodname = "get_".$req->getMethod();
		
		if ($req->getParam () !== NULL)
			$result = $obj->{$methodname}($req->getParam());
		
		else
			$result = $obj->{$methodname}();
		
		return $result;
	}
	
	/**
	 * Loades all the user classes in the classes_array
	 * TODO: find way to do this with __autoload
	 */
	private function load_classes ()
	{
		global $classes_array;
		
		foreach ($classes_array as $class)
			require_once (RESOURCE_FOLDER."/".$class.".class.php");
	}
}

?>