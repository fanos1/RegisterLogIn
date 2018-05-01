<?php

/**
* 
*/
class Validator
{
    
	protected $valid = array(); 		// Will store sanitized form inputs after validation
	protected $reg_errors = array();
	protected $login_errors = array();	
	

	public function __construct()
	{
		# code...
	}

    /*
     * This function validates Form Inputs. If all submited POST[] inputs are valid, TRUE is returned
     * If validation errors exist, these are recorded to $reg_errors Array
     * POST[] inputs which pass the validation are recorded in the $valid Array
     */
    public function validateRegistForm() {    	

    	/* 
    	 //check if the form submited is our own form
		if( strip_tags($_POST['formtoken']) !== $_SESSION['formtoken'])  {
			$this->reg_errors['formtoken'] = "The form submited is not valid. Please try again or contact support for additional assistance."; 

		} 

		//honeypot field is hidden, and user will not be able to input value, only bots will populate that field    
		$honeypot = trim(strip_tags($_POST['med']) );   
		if(!empty($honeypot)) {
			$this->reg_errors['hp'] = "The form submited is not valid. Please try again or contact support for additional assistance.";
		} 
		*/
		

    	// first name:
	    if (preg_match('/^[A-Z \'.-]{2,45}$/i', $_POST['first_name'])) {
	        
	        $fn = strip_tags( $_POST['first_name']);
	        $_SESSION['first_name'] = $fn;
	        //$valid['fn'] = $fn;
	        $this->valid[] = $fn;

	    } else {
	        // $reg_errors['first_name'] = 'Please enter valid first name!';
	        $this->reg_errors['first_name'] = 'Please enter valid first name!';
	    }


	    if (preg_match('/^[A-Z \'.-]{2,45}$/i', $_POST['last_name'])) {
	        // $ln = $_POST['last_name'];
	        $_SESSION['last_name'] = $_POST['last_name'];
	        $this->valid[] = $_POST['last_name'];
	    } else {
	        $this->reg_errors['last_name'] = 'Please enter valid last name!';
	    }
	 
	 	/* 
	    if (preg_match('/^[A-Z0-9]{2,45}$/i', $_POST['username'])) {
	        $u = $_POST['username'];
	        $_SESSION['username'];
	    } else {
	        $reg_errors['username'] = 'Please enter a desired name using only letters and numbers!';
	    }
	    */

	     // Is the submited Email valid? if it's valid
	    if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === $_POST['email']) {
	        $e = $_POST['email'];
	        $_SESSION['email'] = $e;
	        $this->valid[] = $e;
	    } else {
	        $this->reg_errors['email'] = 'Please enter a valid email address!';
	    }
	    

	    //City
	    /*
	    if (preg_match('/^[a-z]{2,16}$/i', $_POST['city'])) {

	        $this->valid[] = $_POST['city'];
	    } else {
	        $this->reg_errors['city'] = 'Please enter your city!';
	    }
	    */


	    // Check for a password and match against the confirmed password:
	    if (preg_match('/^(\w*(?=\w*\d)(?=\w*[a-z])(?=\w*[A-Z])\w*){6,}$/', $_POST['password']) ) {
	        
	        if ($_POST['password'] === $_POST['confirm_password']) {
	            //$p = $_POST['password'];
	        	$this->valid[] = $_POST['password'];
	        } else {
	            $this->reg_errors['confirm_password'] = 'Your password did not match the confirmed password!';
	        }                
	        
	    } else {
	        $this->reg_errors['password'] = 'passwords must have at least one Capital Letter and one number,!';
	    }
	    
	    //ADDRESS
	    /* 
	    if (preg_match('/^[A-Z0-9 \',.#-]{1,100}$/i', $_POST['address1'])) {
	        // $address1 = $_POST['address1'];
	        $this->valid[] = $_POST['address1'];
	        $_SESSION['address1'] = $_POST['address1'];
	    } else {
	        $this->reg_errors['address1'] = 'Please enter your addres1 name!';
	    }
	    */

        //TELEPHONE
	    if (preg_match('/^[0-9]{6,16}$/i', $_POST['telephone'])) {	        
	        //$tel = $_POST['telephone'];
	    	$this->valid[] = $_POST['telephone'];
	        $_SESSION['telephone'] = $_POST['telephone'];
	    } else {
	        $this->reg_errors['telephone'] = 'Please enter your telephone!';
	    }
	    
	    //POSTCODE
	    /*
	    if (preg_match('/^(GIR 0AA)|(TDCU 1ZZ)|(ASCN 1ZZ)|(BIQQ 1ZZ)|(BBND 1ZZ)|(FIQQ 1ZZ)|(PCRN 1ZZ)|(STHL 1ZZ)|(SIQQ 1ZZ)|(TKCA 1ZZ)|[A-PR-UWYZ]([0-9]{1,2}|([A-HK-Y][0-9]|[A-HK-Y][0-9]([0-9]|[ABEHMNPRV-Y]))|[0-9][A-HJKS-UW])\s?[0-9][ABD-HJLNP-UW-Z]{2}$/i', $_POST['postcode'])) {
	        	        
	        $pc = filter_var($_POST['postcode'], FILTER_SANITIZE_STRING);
	        $this->valid[] = $pc;
	        $_SESSION['postcode'] = $pc;
	    
	    } else {
	        $this->reg_errors['postcode'] = 'Please enter postcode!';
	    }  
	    */
	   

		if (empty($this->reg_errors) ) { 
			return TRUE; // IF no Errors, It means All inputs are valid, in this case Return TRUE			
		}
		return FALSE; 

    } 


    /*
     * Validate Login Form inputs 
     */
    public function validateLoginForm() 
    {
    	/* 
    	 //check if the form submited is our own form
		if( strip_tags($_POST['formtoken']) !== $_SESSION['formtoken'])  {
			$login_errors['formtoken'] = "The form submited is not valid. Please try again or contact support for additional assistance.";        
		} 

		//honeypot field is hidden, and user will not be able to input value, only bots will populate that field    
		$honeypot = trim(strip_tags($_POST['med']) );   
		if(!empty($honeypot)) {
			$login_errors['hp'] = "The form submited is not valid. Please try again or contact support for additional assistance.";
		} 
		*/
				
	    
	    // Validate the email address:
	    if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {                    
	        $e = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);    
	        $this->valid[] = $e;                
	    } else {
	        $this->login_errors['email'] = 'Please enter a valid email address!';
	    }

	    // Validate the password:
	    if (preg_match('/^(\w*(?=\w*\d)(?=\w*[a-z])(?=\w*[A-Z])\w*){6,22}$/', $_POST['password']) ) {
	    //if (!empty($_POST['password'])) {
	        $p = $_POST['password'];
	        $this->valid[] = $p;
	    } else {
	        $this->login_errors['password'] = 'Please enter your password! Minimum 6 and maximum 22 characters';
	    }
	    
	    
		if (empty($this->login_errors) ) { 
			return TRUE; // IF no Errors, It means All inputs are valid, in this case Return TRUE			
		}
		return FALSE; 

    }

    public function getValidInputs() {
    	return $this->valid; // Return valid input value array
    }

    public function getErrors() {
    	return $this->login_errors; // return error messages
    }


}