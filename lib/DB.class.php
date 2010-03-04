<?php

/**
 * Class that interacts with MySQL databases, and
 * provides a simple and abstract way to use.
 */
class DB {
    
    private $conn;
    
    //database data
    private $dbhost;
    private $dbname;
    private $dbuser;
    private $dbpass;
    
    /**
     * Constructor
     * @dbhost string the database host
     * @dbname string the database name
     * @dbuser string the database username
     * @dbpass string the database password
     */
    public function __construct ($dbhost, $dbname, $dbuser, $dbpass)
    {
        $this->dbhost = $dbhost;
        $this->dbname = $dbname;
        $this->dbuser = $dbuser;
        $this->dbpass = $dbpass;

	$this->connect();
    }
    
    /**
     * Connects to mysql database
     */
    private function connect ()
    {
        $this->conn = mysql_connect ($this->dbhost, $this->dbuser, $this->dbpass)
        or die ("DB :: Error connecting to database");
        
        mysql_select_db ($this->dbname) or die ("DB :: Error selecting database");
    }
    
    /**
     * Closes the connection to a database
     */
    public function __destruct ()
    {
        mysql_close ($this->conn);
    }
    
    /**
     * Executes a given query string
     * @param string $query the query to execute
     * @return mixed the result object on success, False otherwise
     */
    public function query ($query)
    {
		//$q = mysql_real_escape_string ($query);
        $result = mysql_query($query, $this->conn)
        or die ("Error executing query: ".$query);
        
        return $result;
    }
}
?>
