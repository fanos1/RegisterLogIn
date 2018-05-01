<?php 
session_start();

include __DIR__.'/../config.php';

require INCLUDES. '/lib/password.php';

require(PDO);
$dbc = dbConn::getConnection();


// $login_errors = array();


if($_SERVER['REQUEST_METHOD'] === 'POST' ) 
{

    // Class Validator()  autoloaded
    $obj = new Validator(); // $_POST[] is superglobal, accessable from the USER Class

    // if Login form inputs are valid, fetch valid inputs. Else fetch errors
    if ( $obj->validateLoginForm() )  {

        list($e, $p ) = $obj->getValidInputs();

           try {                   
                //First we fetch the salt which we will concatenate
                $q = 'SELECT COUNT(*) AS howmany_users, 
                    user_id, password, email, first_name
                    FROM user 
                    WHERE email = :email';  
                
                
                $stmt = $dbc->prepare($q);
                $stmt->bindValue(':email', $e); 
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
              
                $hash = $row['password'];
                //We check if user with submited email and submited password exist in DB
                //$saltedPass = $p.$row['salt'];                
                //if( password_verify($saltedPass, $row['password']) ) {
                
                if( password_verify($p, $hash) ) {
                    
                    // If the user is an administrator, create a new session ID to be safe:
                    // This code is created at the end of Chapter 4:
                    if ($row['type'] == 'admin') {
                        session_regenerate_id(true);
                        $_SESSION['user_admin'] = true;
                    }

                    // Store the data in a session:
                    $_SESSION['user_id'] = $row["user_id"];

                    $_SESSION['username'] = $row['username'];
                    $_SESSION['email'] = $row['email'];

                    $_SESSION['login_success'] = 1;
                   
                } 
                
            } 
            catch (PDOException $e) 
            {        
                //$file = $e->getFile();
                //$line = $e->getLine();
                //$message = $e->getMessage();
                //$trace = $e->getTrace();
                //$theErrorString = "$file :: $line :: $message :: $trace";
                
                //echo "<h3>".$e->getMessage()."</h3>"; //debug                
                //error_log($theErrorString, 0); //Log Error in server's PHP file       
                echo 'An exception error occured, Sorry!';
            }
       

    }
    else // ERRORS 
    {
            $login_errors = $obj->getErrors();
            var_dump($login_errors);
            exit("<h3>LOGIN ERRORS VALIDATION OCCURED</h3>");
            // $login_errors['email']
    }
       

}

//just before starting HTML, create a new formtoken
$_SESSION['formtoken'] = md5(uniqid(rand(), true));
//sanitize formtoken which will be outputed in the login form as <hidden input>
$formToken = htmlspecialchars($_SESSION['formtoken']);



//============ HTML ================
//============ HTML ================

// if (!isset($login_errors)) $login_errors = array(); // Create an empty error array if it doesn't already exist:

include(TEMPLATES. 'header.html.php');

if(isset($_SESSION['login_success'])  ) {
    echo 'logged in successfully ';
} else {
    include ( VIEWS . "login_view.php" );        
}

include(TEMPLATES. 'footer.html.php');  ?>

