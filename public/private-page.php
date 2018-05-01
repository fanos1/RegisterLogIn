<?php
include __DIR__.'/../config.php';

User::isUserLoggedIn();

try {

    require(PDO);
    $dbc = dbConn::getConnection();
	

} catch (PDOException  $e) {
    echo $e->getTraceAsString();     
    exit('Error with database 40');
    
} catch (Exception $exc) {
    echo $exc->getTraceAsString();     
    // error_log('Exception: ' . $exc->getMessage() . ' in file ' . $exc->getFile() . ' on line ' . $exc->getLine());
     
} 

// ============ HTML ===============
// ============ HTML ===============
// ============ HTML ===============
include (TEMPLATES. 'header.html.php');
?>
<div class="container">
	<div class="col-12">
		<h1> SHOW THIS PAGE ONLY IF USER IS LOGGED IN! </h1>
	</div>
</div>