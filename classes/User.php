<?php

class User {

    
    
    function __construct() {
        
    }
    
    /*
     * Check if username and email is availabe to register
     * 
     * Returns an integer: 0 int is if both username and pass is available to be taken. 1 int is if either email our username is taken
     * 
     */
    public static function isUsernamePassAvailable($dbc, $u, $e) {
        
        $result = (int) 2; // Defalut is both username and password are NOT available
        
        $q = "SELECT COUNT(*) AS num_row FROM user WHERE username=:username OR email =:email";   
        // $q = "SELECT COUNT(*) AS num_row FROM user WHERE email =:email";   

        $stmt = $dbc->prepare($q);
        $stmt->bindParam(':username', $u );
        $stmt->bindParam(':email', $e);
        $stmt->execute();            
        $rows = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($rows['num_row'] == 0 ) { // if both email and user available, INSERT                
            $result = (int) 0;
        } else if ($rows['num_row'] == 1) { //either email or username is taken                                         
            $result = (int) 1;
        } else if ($rows['num_row'] == 2) { //Both email and username taken                                
            $result = (int) 2;
        }

        return $result;

    }
    
    
    /*
     * 
     */
    public static function isUserEmailAvailable($dbc, $e) {
        
        // $result = (int) 2; // Defalut is both username and password are NOT available
        $result = FALSE; // Default is Email NOT available
           
        // $q = "SELECT COUNT(*) AS num_row FROM user WHERE username=:username OR email =:email";   
        $q = "SELECT COUNT(*) AS num_row FROM user WHERE email =:email";   

        $stmt = $dbc->prepare($q);
        $stmt->bindParam(':email', $e);
        $stmt->execute();            
        $rows = $stmt->fetch(PDO::FETCH_ASSOC);

        //var_dump($rows);

        // if no record in databae with this Email, the eimail is available to register, Return TRUE
        // if ($rows['num_row'] === 0 ) {  // PDO fetch() returns STRING, use == equal sign
        if ($rows['num_row'] == 0 ) {
            $result = TRUE;
        } 
        return $result;              
    }
    

    /*
     * Register user into the the 'signup' Database table
     * 
     * Users are first recoreded in the signup table with a confirmation code
     * Once user clicks that confirmation code, he/she is registered into the 'user' Table
     * Onlyc users who have registration row in the 'user' Table are given access to hidden parts of the website
     * 
     * $db - Database connection instance
     * $u - Username
     * $e - email of user
     * $p - password
     */
    public static function registerUseIntoSignupTable($dbc, $p, $e, $first_n,  $last_n, $tel, $confirmCode) {              
                           
        $hashedPassw = password_hash($p, PASSWORD_BCRYPT);     //this hashing is strongler than sha512()
        // $time_creat = time(); //$stmt->bindParam(':time', time()); 

            $sql = "INSERT INTO signup ( password,  email, first_name, last_name, telephone, confirm_code )
                VALUES ( :password,  :email, :first_name, :last_name, :telephone, :confirm )"; 

            
        $stmt = $dbc->prepare($sql);    
        $stmt->bindParam(':password', $hashedPassw);                     
        $stmt->bindParam(':email', $e);   
        $stmt->bindParam(':first_name', $first_n);  
        $stmt->bindParam(':last_name', $last_n);  
        $stmt->bindParam(':telephone', $tel);  
        $stmt->bindParam(':confirm', $confirmCode);                        
       // $stmt->bindParam(':time', $time_creat);                      
        $result= $stmt->execute();                
        //var_dump($rusult); // bool(true)

        if($result) {
            return TRUE;
        } else {
            return FALSE;
        }
       
    }
    
    
    public static function sendSignUpEmail() {
        // TESTING
        // return TRUE;
        
        $confirmationURL = '
          <a href="https://www.example.co.uk/signup.php?code='.$confirmCode.'"> 
              https://www.example.co.uk/signup.php?code='.$confirmCode.'
          </a>';
        
        $mail = new PHPMailer;
        /* 
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp1.example.com;smtp2.example.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'user@example.com';                 // SMTP username
        $mail->Password = 'secret';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to 
        * 
        */ 
        $mail->From = "info@register.co.uk";
        $mail->FromName = "Example  Ltd.";
        //$mail->setFrom('from@example.com', 'Mailer');

        //$mail->addAddress('irfankissa@yahoo.com', 'Joe User');                // Add a recipient
        $mail->addAddress($e);                                                  // Name is optional
        $mail->addReplyTo('info@example.co.uk', 'Information Reply To');
        $mail->addCC('irfankissa@yahoo.com');
        //$mail->addBCC('bcc@example.com');
        //$mail->addAttachment('/var/tmp/file.tar.gz');                 // Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');            // Optional name

        $mail->isHTML(true);                                            // Set email format to HTML :: Send HTML or Plain Text email

        $mail->Subject = 'Account Confirmation';
        $mail->Body    = '<html>
        <body>
            <h2>Thank you for registering!</h2>
            <div>The final step is to confirm
            your account by clicking on:</div>
            <div>'.$confirmationURL.'</div>
            <div>
            <b>Your Site Team</b>
            </div>
        </body>
        </html>';                
        $mail->AltBody = 'Please click this link to confirm your registration: '.$confirmationURL; //This is the body in plain text for non-HTML mail clients

        if(!$mail->send()) {
            // echo 'Mailer Error: ' . $mail->ErrorInfo;
            // exit('cik');
            return FALSE;                
        } else {
            return TRUE;
        }
    }
    
    public static function confirm($dbc, $confirmCode) {
        
        try {
            //We select from the signup table all records that have a value in the confirm_code column         
            $sql = "SELECT * FROM signup WHERE confirm_code =:confirmCode";
            $stmt = $dbc->prepare($sql);
            $stmt->bindParam(':confirmCode', $confirmCode);
            $stmt->execute();
            $row = $stmt->fetchAll();        

            // var_dump($row);
            // exit('cik');
            return $row;             
             
        } catch (PDOException $ex) {
            exit('We apologise! Database Error occured str1');
            /*
            echo '<h3>'.$ex->getLine().'</h3>';
            echo '<h3>'.$ex->getMessage().'</h3>';
            echo '<h3>'.$ex->getCode().'</h3>';            
            */
        }
        
        
    }

    
    public static function registerUserIntoUserTable($dbc,  $pass, $email, $first_name, $last_name, $tel) {
        
       
            $q = "INSERT INTO user(password, email, first_name, last_name, tel ) 
            VALUES (:pass, :email, :first_name, :last_name, :tel )";

            $stmtp = $dbc->prepare($q);
            $stmtp->bindParam(':pass',$pass);
            $stmtp->bindParam(':email',$email); 
            $stmtp->bindParam(':first_name',$first_name); 
            $stmtp->bindParam(':last_name',$last_name); 
            $stmtp->bindParam(':tel', $tel); 


            if(!$stmtp->execute() ) {
                return FALSE;
            } else {
                /* --------------------------------- 
                *  We need to delete this record from 'signup' table because we transfered it to 'user' table successfully
                *  WILL DELETE THEM PERIODICALLY FROM phpMyAdmin
                * --------------------------------

                $sql = "DELETE FROM signup WHERE signup_id = :id";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(':id', $row[0]['signup_id']);            
                if($stmt->execute() ) { echo "<h3>line 288, CLASS signup, items taken from SIGNUP table, and INSERTED into USER table</h3>";   }            
                */

                //$successSignup = true;                    
                return TRUE;
            }
            
       
    }

        /*
     * Check if user is logged in? if not redirect
     * Takes 2 arguments:
     * - The session element to check
     * - The destination to where the user will be redirected.
     */
    public static function isUserLoggedIn($check='user_id', $destination='index.php', $protocol ='https://' ) {
      
            // Check for the session item:
            if (!isset($_SESSION[$check])) { //i.e. $_SESSION['user_admin']

                $url = $protocol . BASE_URL . $destination; // Define the URL.
                header("Location: $url");
                exit();
            }
        
    }
    

    
    
    
}