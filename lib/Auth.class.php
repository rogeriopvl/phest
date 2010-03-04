<?php

/**
 * This class provides multiple authentication methods for rest9 API
 * You can choose auth by APIKEY, by allowed IP
 */
class Auth
{
	private $db; // to be initialized only when using DB
	private $type;
	
	/**
	 * Constructor method
	 */
	public function __construct ($type)
	{
		require_once ('config.inc.php');
		$this->type = $type;
	}
	
	/**
	 * Checks the type of authentication and returns the right method
	 * @param string $value the value, it can be an IP or APIKEY
	 * @return bool true if auth valid, false otherwise
	 */
	public function check_auth ($value)
	{
		if ($this->type === "IP")
			$valid = check_auth_by_IP ($value);
			
		else if ($this->type === "APIKEY")
			$valid = check_auth_by_APIKEY ($value);
			
		else
			throw new Exception ("Wrong type of authentication.");
		
		return $valid;
	}
	
	/**
	 * Checks for valid authentication using IP whitelist
	 * @param string $ip the ip to validate
	 * @return bool true if valid, false otherwise
	 */
	private function check_auth_by_IP ($ip)
	{
		if (in_array ($ip, $allowed_hosts))
			return true;
		else
			return false;
	}
	
	/**
	 * Checks for valid authentication using a apikey
	 * @param string $key the key to validate
	 * @return bool true if valid key, false otherwise
	 */
	private function check_auth_by_APIKEY ($key)
	{
		$this->start_db ();
		$res = $this->db->query ("SELECT * FROM ".KEYS_TABLE." WHERE key=$key");
		
		if (mysql_num_rows ($res) < 1)
			return false;
		else
			return true;
	}
	
	/**
	 * Starts the database connection
	 */
	private function start_db ()
	{
		require_once (HELPER_FOLDER.'/DB.class.php');
		
		$this->db = new DB (DB_HOST, DB_NAME, DB_USER, DB_PASS);
	}
}
?>