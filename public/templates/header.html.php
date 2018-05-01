<!doctype html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1"/> 
    <meta name="description" content="<?php echo isset($page_desc) ? $page_desc : 'Fresh raw walnuts, almonds and pistachios. Free delivery in London'; ?>" />
    <title>
        <?php echo isset($page_title) ? $page_title : 'Dobaln | bulk walnuts to buy | Nuts to buy '; ?>
    </title>


    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans" rel="stylesheet">

    <link href="/css/custom.css" media="all" rel="stylesheet" type="text/css" />	

</head>


<body>


    <!-- <a href="#content" class="sr-only sr-only-focusable">Skip to main content</a> -->


    <header id="header" style="">	
            <?php
                if (isset($_SESSION['user_id'])) { // if user is Logged in                  

                    echo ' 
                        <nav class="container" id="commonlinks"  >          
                            <div class="col-6"> 
                                <a href="#">Logout </a>
                            </div>
                            <div class="col-6">
                                <a href="#">Change Password </a>
                            </div>
                            
                        </nav>';

                } else { // if user not logged in
                                        
                    echo ' 
                        <nav class="container" id="commonlinks"  >          
                            <div class="col-6"> 
                                <a href="/login.php" title="login">Login </a>
                            </div>
                            <div class="col-6" style="text-align: right;">
                                <a href="/signup.php" title="signu">Register </a>
                            </div>
                        </nav>';
                }

            ?>
        


    </header>

