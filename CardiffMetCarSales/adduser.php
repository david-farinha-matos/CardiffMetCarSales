<!DOCTYPE html>
<html lang="en-GB">
    <head>      
        <title>CIS4004 - University modules</title>
        <meta charset="utf-8">
        <meta name="author" content="Thanuja Mallikarachchi">
		<meta name="Description" content="Home page for CIS4004">
		<meta name="keywords" content="home, cis4004, web">
		<meta name="viewport" content="width=device-width, initial-scale=1">	
		
        <link rel="stylesheet" href="css/index.css" />
        
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        
        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> 
    
    </head>
    <body>
        <main class="container">
            <!-- Header -->
            <header class="row">
                <div class="col-12">                                            
                    <div style="margin: auto; width: 100%; border: 1px dashed deeppink; padding: 10px;">
                        <h1> <!-- Provide a suitable heading. --> ?? </h1>                              
                    </div>
                    
                </div>
            </header>

            <br>
            <section class="row">
                <div class="col-12">
                    <nav id="main_nav">
                        <ul id="main_nav_ul">
                            <li><a class="active" href="index.html">Home</a></li>
                            <li><a href="registration.php">Registration</a></li>
                            <li><a href="#">My modules</a></li>
                        </ul>
                    </nav>
                </div>
            </section>

            <h1> adduser.php web page </h1>
            
            <?php

            // declared variables to store the form data entered by the users
            $forename = $_POST["forename"];
            $surname = $_POST["surname"];
            $username = $_POST["username"];
            $password = $_POST["password"];
            $age = $_POST["age"];
            $gender = $_POST["gender"];
            $email = $_POST["email"];

            ?>

            <section class="row">
                <div class="col-12">
                    <h3 style="border: 1px solid black;"> <?php echo "The first name is; " . $forename . "<br>"; ?> </h3>
                    <h3> <?php echo "The last name is; " . $surname . "<br>"; ?> </h3>
                    <h3> <?php echo "The username name is; " . $username . "<br>"; ?> </h3>
                    <h3> <?php echo "The password name is; " . $password . "<br>"; ?> </h3>
                    <h3> <?php echo "The age name is; " . $age . "<br>"; ?> </h3>
                    <h3> <?php echo "The gender name is; " . $gender . "<br>"; ?> </h3>
                    <h3> <?php echo "The email name is; " . $email . "<br>";?> </h3>

                </div>
            </section>

                     




            
            <hr>                        

            <!-- End of main body -->
            <footer class="row">
                <div class="row col-12 justify-content-center" style="border: 1px dashed deeppink;">
                    <!-- Replace the content with your name and email address -->
                    <div class="col-sm-6" style="text-align: left;">                             
                        <p>Copyright &copy; Thanuja Mallikarachchi</p>                    
                    </div>
                    <div class="col-sm-6" style="text-align: right;">
                        <p>Contact us: tmallikarachchi@cardiffmet.ac.uk</p>                        
                    </div>
                </div>
            </footer>         
            
        </main>

        <script>
        </script>
    </body>    
</html>
