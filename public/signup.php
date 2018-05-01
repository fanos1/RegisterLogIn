<?php
session_start();

include __DIR__.'/../config.php';

require INCLUDES. '/lib/password.php';

//require (CLASSES. 'PHPMailerAutoload.php');
// require (CLASSES. 'class.phpmailer.php');
//require './classes/class.smtp.php';
//require './classes/class.pop3.php';


// include ('/../classes/Validator.php');

// Classes are autoloaded

require(PDO);
$dbc = dbConn::getConnection();


$reg_errors = array();
$errors = array();

if($_SERVER['REQUEST_METHOD'] === 'POST' ) 
{
    try {
        $obj = new Validator(); // $_POST[] is superglobal, it should be accessable from the USER Class

        //==================
        // no errors : if submited inputs are valid, validateSubmitTorm() returns TRUE if All Valid
        //=========== 
        if ( $obj->validateRegistForm() ) 
        { 
            list($fn, $ln, $e,  $city, $p, $address1, $tel, $pc ) = $obj->getValidInputs();
            
            // IS the email taken? if still available, register user
            if (User::isUserEmailAvailable($dbc, $e) )  {
                
                // exit('user email is availabel to be taken');
                
                srand( (double)microtime() * 1000000 );  //Seed the random number generator  				
                // $confirmCode = md5($u . time() . rand(1, 1000000));
                 $confirmCode = md5( time() . rand(1, 1000000));

                //  Record the user into SignUp TABLE, if successful, send email
                if( User::registerUseIntoSignupTable( $dbc, $p, $e, $fn,  $ln, $tel, $confirmCode ) ) { 
                    
                    // Now that SIGNUP table is populated, send email                                     
                    if( User::sendSignUpEmail() ) {
                        
                        //echo "<h3>Message has been sent</h3>";
                        $sentSuccess = '<div class="alert alert-success">
                                <strong>We have sent you an email!</strong> Please check your email and click the link to complete your registration
                        </div>';

                        // unset($_SESSION['first_name']);
                        $_SESSION['first_name'] = "";
                        unset($_SESSION['last_name']);                        
                        unset($_SESSION['username']);                        
                        unset($_SESSION['address1']);
                        unset($_SESSION['email']);
                        unset($_SESSION['postcode']);
                        unset($_SESSION['telephone']);                        
                        // unset($_POST);   // CALISMADI
                        // $_POST = array(); // CALISMADI
                    } else {
                        //throw new SignUpEmailException('Error sending confirmation' .' email: ' .$mail->ErrorInfo );
                        echo 'Message could not be sent.'; 
                        echo 'Mailer Error: ' . $mail->ErrorInfo;
                        exit('cik');
                    }

                }


            } else {
                exit("<h3>user email not availble</h3>");
            }           

        } 
        else // ERRORS 
        {
            $reg_errors = $obj->getErrors();
            var_dump($reg_errors);
            exit("<h3>ERRORS VALIDATION OCCURED</h3>");
            // $reg_errors['first_name']
        }
    }
    catch (Exception $ex) {
        echo '<h3>'. $ex->getLine() . ' - '. $ex->getMessage() .'</h3>';
        exit("cik");
    }
    catch (PDOException $e) {
        echo '<h3>'. $e->getCode() . ' - '. $e->getMessage() .'</h3>';
        exit("cik");
    }    
    
} //END POST


// The next step is to check whether the page is being requested as part of a confirmation. 
// — we’ll check for the presence of the $_GET['code'] variable
// If the confirmation code is present, we call the SignUp->confirm(), supplying the code the page received. 
// We then set the $html variable, which will contain the page title and message to display on our web page.
if (isset($_GET['code']) && strlen($_GET['code']) === 32 ) {
    
    try {        
        //$signUp->confirm($_GET['code']);
        $confirmCode = strip_tags($_GET['code']);       
        
        $row = User::confirm($dbc, $confirmCode);                 
        
        $howManyRows = count($row);//Count all elements in Array
        
        // We should have only 1 record with that particular confirmation number
        if($howManyRows === 1 ) { 
            
            if( User::registerUserIntoUserTable($dbc,  $pass, $EMAIL, $FIRST_NAME, $LAST_NAME, $TEL) ) {
                 exit('successful insert INTO USER TABLE');
            } else {
                exit('COULD NOT REGISTER USE INTO USER TABLE');
            }
                        
        } else {            
            exit('more than 1 record returnd');
        }
            
        
    }  catch (PDOException $e) {
        var_dump($e->getMessage()); //FOR DEBUGGING
        //for user display
        echo '<h3>'. $reg_messages['confirm_error'] . '</h3>'; 
    }
    catch (SignUpException $e) {             
        var_dump($e->getMessage()); //FOR DEBUGGING
        //for user display
        echo '<h3>'. $reg_messages['confirm_error'] . '</h3>'; 
    }

}


//just before starting HTML, create a new formtoken
$_SESSION['formtoken'] = md5(uniqid(rand(), true));
//sanitize formtoken which will be outputed in the login form as <hidden input>
$formToken = htmlspecialchars($_SESSION['formtoken']);



// ================= HTML ===============
// ================= HTML ===============
include(TEMPLATES. 'header.html.php');

if(isset($successSignup)) {
    //include successful message view
    include ( VIEWS . "signup_success_view.php" ); 
} else {
    include ( VIEWS . "signup_view.php" );    
}
include(TEMPLATES. 'footer.html.php');  ?>
	
