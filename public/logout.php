<?php
session_start();

require (__DIR__ .'/../includes/config.inc.php');
require INCLUDES. '/lib/password.php';

// This page is used to change an existing password.
// Users must be logged in to access this page.
// If the user isn't logged in, redirect them:
User::isUserLoggedIn();

require(PDO);
$dbc = dbConn::getConnection();



function logoutUser() 
{
    /*
     *      
     ******************************************** 
     * taken from PHP documentation: 
     * http://php.net/manual/en/function.session-destroy.php 
     * **************************************************************
        session_cache_expire — Return current cache expire
        session_cache_limiter — Get and/or set the current cache limiter
        session_commit — Alias of session_write_close
        session_decode — Decodes session data from a session encoded string
        session_destroy — Destroys all data registered to a session
        session_encode — Encodes the current session data as a session encoded string
        session_get_cookie_params — Get the session cookie parameters
        session_id — Get and/or set the current session id
        session_is_registered — Find out whether a global variable is registered in a session
        session_module_name — Get and/or set the current session module
        session_name — Get and/or set the current session name
        session_regenerate_id — Update the current session id with a newly generated one
        session_register_shutdown — Session shutdown function
        session_register — Register one or more global variables with the current session
        session_save_path — Get and/or set the current session save path
        session_set_cookie_params — Set the session cookie parameters
        session_set_save_handler — Sets user-level session storage functions
        session_start — Start new or resume existing session
        session_status — Returns the current session status
        session_unregister — Unregister a global variable from the current session
        session_unset — Free all session variables
        session_write_close — Write session data and end session        
    */
    
    /*
    require_once '/includes/DatabaseSession.class.php';
    $session = new DatabaseSession('root', 'irfan_Fanos', 'session', 'mvc-ecommerce','localhost');
    //register our custom PHP session-handling methods
    session_set_save_handler(array($session, 'open'),
        array($session, 'close'),
        array($session, 'read'),
        array($session, 'write'),
        array($session, 'destroy'),
        array($session, 'gc')
    );
    */
        
    //First, we must initiate session_start(). Check to see if it's already initiated.
    //Note that the most proper way of checking if SESSION is set is by using 
    //session_status() == PHP_SESSION_ACTIVE. However, this function is available only if PHP version > 5.4
    if (strlen(session_id()) < 1 && session_id() == '') {
        session_start();       
    } 
   
    $_SESSION = array(); // Unset all session values
       
    // If it's desired to kill the session, also delete the session cookie.
    // Note: This will destroy the session, and not just the session data!
    if (ini_get("session.use_cookies")) 
    {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);		
    }
	
	/*
	// Destroy the session:
	$_SESSION = array(); // Destroy the variables.
	session_destroy(); // Destroy the session itself.
	setcookie (session_name(), '', time()-300); // Destroy the cookie.
	*/
    
    session_destroy(); // Destroy session
    
    //----- Custom deletion below, because isset(SESSION) continued to be TRUE afte above operatiosns
    unset($_SESSION);
    session_unset(); 
    session_write_close();
    session_regenerate_id(true);               
}


logoutUser(); // Call 



// ============ HTML ===============
// ============ HTML ===============
$page_title = 'Logout';
include (TEMPLATES. 'header.html.php');

echo '
	<div class="container">
		<div class="col-12">
			<h3 class="alert alert-success">Logged Out</h3>
			<p>Thank you for visiting. You are now logged out. Please come back soon!</p>
		</div>
	</div>
	';


include (TEMPLATES. 'footer.html.php');
?>