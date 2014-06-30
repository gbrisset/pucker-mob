<?php
class SDConnector{
	private $connection;
	private $error;
	private static $instance;

	/**
	 *	Get an instance of the database
	 *	@return Database 
	**/
	public static function getInstance(){
		if(!self::$instance){
			self::$instance = new self(); 
		}
		return self::$instance;
	}

	/**
	 * Constructor
	 */
	public function __construct(){
	    $this->connection = new PDO('mysql:host='.DB_SERVER.';dbname='.DB_NAME, DB_USER, DB_PASS);
	    $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	/**
	 * Empty __clone magic method to prevent duplication.
	 */
	private function __clone(){}

	public function getConnection(){
		return $this->connection;
	}

}
?>