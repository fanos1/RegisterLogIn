
<div class="container" style="padding-top: 30px;">
    
    <div class="col-12">
        <div class="alert alert-info" role="alert">
            Input your delivery address details. You will receive an email with a link, which you will need to click 
            on to complete your registration.
        </div>
    </div>

</div>


<div class="container">
   
    <form action="" method="post" name="regForm" id="regForm">    


            <div class="col-6">
			
                <input type="hidden" name="formtoken" id="formtoken" value="<?php echo $formToken; ?>" />
                <p style="display: none;"> <input type="text" name="med" id="med" value=""> </p>

                <div class="form-group">
                    <label for="first_name"> first_name<sup>*</sup></label>            
                    <input class="form-control" name="first_name" type="text" value="<?php echo isset($_SESSION['first_name']) ? htmlspecialchars($_SESSION['first_name']) : ''; ?>" />                                                                                            
                    <?php
                    if (!empty($reg_errors['first_name'])) {
                        echo '<div class="alert alert-danger">' . $reg_errors['first_name'] . '</div>';
                    }
                    ?>
                </div>
                <div class="form-group">
                    <label for="last_name"> last_name<sup>*</sup></label>            
                    <input class="form-control" name="last_name" type="text" value="<?php echo isset($_SESSION['last_name']) ? htmlspecialchars($_SESSION['last_name']) : ''; ?>" />                                                                                            
                    <?php
                    if (!empty($reg_errors['last_name'])) {
                        echo '<div class="alert alert-danger">' . $reg_errors['last_name'] . '</div>';
                    }
                    ?>
                </div>
               
				
                <div class="form-group">
                    <label for="password"> password<sup>*</sup></label>            
                    <input class="form-control" name="password" type="password" value="" />                                                                                            
                    <?php
                    if (!empty($reg_errors['password'])) {
                        echo '<div class="alert alert-danger">' . $reg_errors['password'] . '</div>';
                    }
                    ?>
                </div>

                <div class="form-group">
                    <label for="confirm_password"> confirm_password<sup>*</sup></label>            
                    <input class="form-control" name="confirm_password" type="password" value="" />                                                                                            
                    <?php
                    if (!empty($reg_errors['confirm_password'])) {
                        echo '<div class="alert alert-danger">' . $reg_errors['confirm_password'] . '</div>';
                    }
                    ?>
                </div>	
				
            </div>
			
            <div class="col-6">
				
                <div class="form-group">
                    <label for="email"> email<sup>*</sup></label>            
                    <input class="form-control" name="email" type="text" value="<?php echo isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : ''; ?>" />                                                                                            
                    <?php
                    if (!empty($reg_errors['email'])) {
                        echo '<div class="alert alert-danger">' . $reg_errors['email'] . '</div>';
                    }
                    ?>
                </div>
		

                <div class="form-group">
                    <label for="telephone"> telephone<sup>*</sup></label>            
                    <input class="form-control" name="telephone" type="text" value="<?php echo isset($_SESSION['telephone']) ? htmlspecialchars($_SESSION['telephone']) : ''; ?>" />                                                                                            
                    <?php
                    if (!empty($reg_errors['telephone'])) {
                        echo '<div class="alert alert-danger">' . $reg_errors['telephone'] . '</div>';
                    }
                    ?>
                </div>
                <input name="submit" value="Register" type="submit" class="btn btn-warning" style="margin-top: 10px;" /><br/>
            </div>




        </form>
   
</div>




<div class="container">
    
    <div class="col-12">            
        <?php 
        if (isset($sentSuccess)) {
            echo $sentSuccess;
        } 
        if (isset($errors)) {
            foreach ($errors as $v) {
                echo '<div class="alert alert-danger">' . $v . '</div>';
            }
        }
        ?>
    </div>
    
</div>

