<?php


include __DIR__.'/../config.php';


try {

    require(PDO);
    $dbc = dbConn::getConnection();
	

} catch (PDOException  $e) {
    // echo $e->getTraceAsString();     
    exit('Error with database 40');
    
} catch (Exception $exc) {
    // echo $exc->getTraceAsString();     
    error_log('Exception: ' . $exc->getMessage() . ' in file ' . $exc->getFile() . ' on line ' . $exc->getLine());
     
} 



echo 'hi';