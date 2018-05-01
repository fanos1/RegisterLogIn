<?php

DEFINE ('DB_USER', 'homestead'); 	
DEFINE ('DB_PASSWORD', 'secret'); 
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', 'your-db-name');
DEFINE ('DB_DSN', 'mysql:host=localhost;dbname=your-db-name');


//db connection class using singleton pattern
class dbConn {
	
	protected static $dbc;
	
	private function __construct() {	
		try {
			
			$options = array(
				PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4',
			); 
			
			self::$dbc = new PDO( DB_DSN, DB_USER, DB_PASSWORD, $options );			
			self::$dbc->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			
		}
		catch (PDOException $e) {			
			exit('Connection Error: We apologise');
		}
	
	}
	
		
		
	public static function getConnection() {	
	
		if (!self::$dbc) {
		//new connection object.
			new dbConn();
		}
		
		//return connection.
		return self::$dbc;
	}

} 
?>