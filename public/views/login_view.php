

<div class="container">
   
   <div class="col-4"> </div>

    <div class="col-4">        
        <form class="form-inline" action="login.php" method="post" accept-charset="utf-8">
            <input type="hidden" name="formtoken" id="formtoken" value="<?php echo isset($formToken) ? $formToken : ''; ?>" />
            <p style="display: none;"> <input type="text" name="med" id="med" value=""> </p>
                
          <div class="form-group">
            <label class="sr-only" for="email">Email address</label>
            <input type="text" name="email" class="form-control" id="email" placeholder="Email">                
          </div>
          <div class="form-group">
            <label class="sr-only" for="password">Password</label>
            <input type="password" name="password" class="form-control" id="password" placeholder="Password">                
          </div>          
            <button type="submit" class="btn btn-primary">Sign in &rarr;</button>
        </form>

        <div>
            <hr>
            <?php 
                
                if(!empty($login_errors['email']) ) {                     
                    echo '<div class="alert alert-danger">'.$login_errors['email'].'</div>';
                }  
                if(!empty($login_errors['password']) ) {                     
                    echo '<div class="alert alert-danger">'.$login_errors['password'].'</div>';
                }     
                if(isset($verificatFailed)  ) {                     
                    echo '<div class="alert alert-danger"> Are you sure you typed the correct Password? </div>';
                }
            ?>
        </div>
    </div>

    <div class="col-4"> </div>
    
</div>