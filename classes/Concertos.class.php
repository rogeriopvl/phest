<?php

define ('TABLE_NAME', 'concerts');

class Concertos extends REST_Module
{
	private $db;
	
	/**
	 * Constructor method
	 */
	public function __construct ()
	{
		require_once (HELPER_FOLDER.'/DB.class.php');
		
		$this->db = new DB (DB_HOST, DB_NAME, DB_USER, DB_PASS);
	}
	
	/**
	 * Implemented method to retrieve all info from the object
	 */
	public function get_all ()
	{
		$data_array = array ();
		$res = $this->db->query ("SELECT * FROM ".TABLE_NAME);
		
		while ($row = mysql_fetch_assoc ($res))
		{
			$data_array[] = $row;
		}
		
		$data_array['success'] = "true";
		$data_array['error_msg'] = "";
		
		return $data_array;
	}
	
	/**
	 * THink about another way to do this, not very nice the function check
	 * for errors that should already be checked.
	 */
	public function get_concerto ($id=NULL)
	{
		if ($id === NULL)
			return $this->error ("Missing argument: id");

		else if (!is_numeric($id))
			return $this->error ("Invalid id");
		
		$res = $this->db->query ("SELECT * FROM ".TABLE_NAME." WHERE id=$id");
		
		if (mysql_num_rows ($res) < 1)
			return $this->error ("Empty results for chosen id");
		
		while ($row = mysql_fetch_assoc ($res))
		{
			$data_array[] = $row;
		}
		
		$data_array['success'] = "true";
		$data_array['error_msg'] = "";
		
		return $data_array;
	}
}
?>