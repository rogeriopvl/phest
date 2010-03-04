<?php

require_once ('config.inc.php');

$auth = new Auth (AUTH_TYPE);

if ($HTTP_X_FORWARDED_FOR)
	$client_ip = $HTTP_X_FORWARDED_FOR;
else
	$client_ip = $['REMOTE_ADDR'];

$server = new REST_Server();
$server->start_server ();


/**
 * Main class that operates the REST server
 */
class REST_Server
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
	 */
	private function load_classes ()
	{
		global $classes_array;
		
		foreach ($classes_array as $class)
			require_once (CLASS_FOLDER."/".$class.".class.php");
	}
}

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

/**
 * Class that represents a XML response
 */
class XMLResponse extends Response
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

class JSONResponse extends Response
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

/**
 * Provides an interface for all modular classes
 * Every modular class must implement this interface
 */
abstract class REST_Module
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