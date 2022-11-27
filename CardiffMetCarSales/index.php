<?php
// session handling PHP code
session_start();
// if(!isset($_SESSION["user_id"])){
//     header("location: sellCars.php");
// }

require "connectionDB.php";
?>


<!DOCTYPE html>
<html>

<head>
    <title>CardiffMetCarSales Home Page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link href="myStyles.css" rel="stylesheet" />

</head>

<body>

    <?php
    $username = $password = "";
    $username_error = $password_error = $dbConnection_error = $credentials_error = "";
    $errorsFound = false;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST["username"];
        $password = $_POST["password"];

        $conn = new mysqli(
            $servername,
            $dbusername,
            $dbpassword,
            $databasename,
            3306
        );

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        echo "Connected successfully \n";

        $sql = "SELECT * FROM users WHERE username=? AND PASSWORD=?";

        $stmt = $conn->prepare($sql);

        // bind params
        $stmt->bind_param("ss", $username, $password);

        // execute the SQL 
        $stmt->execute();

        $checkUser = $stmt->get_result();
        if ($checkUser->num_rows == 0) {
            $credential_error = "Invalid username or password!";
        } else {
            // meaning , username and password 
            $row = $checkUser->fetch_assoc();

            // create session variables, and store user data..
            $_SESSION["username"] = $row["username"];
            $_SESSION["user_id"] = $row["user_id"];

            $stmt->close();
            $conn->close();

            // once the user is logged in, redirect them to the allusermodules.php web page
            header("location: myCars.php");
        }
    }
    ?>



    <!-- Header -->
    <header class="bgColour">
        <div class="row">
            <div class="columnHome">
                <div class="logo">
                    <img src="http://CardiffMetCarSales/images-used/cardiff-met-uni-logo.jpg"></img>
                </div>
            </div>
            <div class="columnHome">
                <h1 class="text">
                    CardiffMetCarSales
                </h1>
            </div>
            <div class="columnHome">
                <table class="tableLogin" style="text-align: center;">
                    <form method="POST" onsubmit="" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" target="_self">
                        <tr>
                            <th colspan="2">Login</th>
                        </tr>
                        <tr>
                            <td>Username:</td>
                            <td>Password:</td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" id="username" name="username" placeholder="Username...">
                                <span class="error"><small id="username_help" class="form-text text-muted"><?php echo $username_error; ?></small></span>
                            </td>
                            <td>
                                <input type="password" id="password" name="password" placeholder="Password...">
                                <span class="error"><small id="password_help" class="form-text text-muted"><?php echo $password_error; ?></small></span>
                            </td>
                        <tr>
                            <th colspan="2"><button type="submit" class="btn btn-default">Log In</button></th>
                        </tr>
                    </form>
                    <tr>
                        <th colspan="2">Click <a href="http://CardiffMetCarSales/registration">here</a> to register!</th>
                    </tr>
                </table>
            </div>
        </div>
    </header>


    <div class="navBar" id="myTopnav">
        <a href="http://CardiffMetCarSales/index" class="currentPage">Home</a>
        <a href="http://CardiffMetCarSales/findCars">Find Cars</a>
        <a href="http://CardiffMetCarSales/sellCars">Sell Cars</a>
        <a href="http://CardiffMetCarSales/myCars">My Cars</a>
        <a href="http://CardiffMetCarSales/aboutUs">About Us</a>
        <a href="http://CardiffMetCarSales/registration">Register</a>
    </div>


    <!-- <section class="row">
        <div class="col-12" style="float: right;">
            <h4> Welcome <a href="#"> <?php echo $_SESSION["username"];  ?> </a> <a href="logout.php"> Logout </a> </h4>
            <hr>
        </div>
    </section> -->

    <br>

    <section class="row">
        <div class="col-sm-4" style="text-align: center; font-size: 2em;">
            <div>
                <p>Welcome to CardiffMetCarSales! Here you can browser all our amazing cars as well as sell your own ones too!</p>
            </div>
        </div>
        <div class="col-sm-4" style="text-align: center;">
            <h1>Contact Us</h1>
            <p>Phone Number:</p>
            <p>029 2041 6070</p>
            <p>Email Address:</p>
            <p>askadmissions@cardiffmet.ac.uk</p>

            <br>
            <p>Monday 9.00am - 5.00pm
                Tuesday 9.00am - 5.00pm
                Wednesday 10.00am - 5.00pm
                Thursday 9.00am - 5.00pm
                Friday 9.00am - 4.30pm</p>
        </div>
        <div class="col-sm-4" style="text-align: center;">
            <h1>Social Medias</h1>
            <div class="col-sm-2" style="width: 49%;">
                <a href="https://www.facebook.com/cardiff.metropolitan.university/">Facebook:
                    <div>
                        <img alt="Facebook Logo" src="http://CardiffMetCarSales/images-used/Facebook-logo.png" style="width: 100%;">
                    </div>
                </a>
            </div>
            <div class="col-sm-2" style="width: 49%;">
                <a href="https://twitter.com/cardiffmet?ref_src=twsrc%5Egoogle%7Ctwcamp%5Eserp%7Ctwgr%5Eauthor">Twitter:
                    <div>
                        <img alt="Twitter Logo" src="http://CardiffMetCarSales/images-used/twitter-logo.jpg" style="width: 100%;">
                    </div>
                </a>
            </div>
        </div>
    </section>
    <section class="row">
        <div class="col-sm-4">

        </div>
        <div class="col-sm-4">

        </div>
        <div class="col-sm-4">

        </div>
    </section>

    <hr>

    <!-- End of main body -->
    <footer class="row">
        <div style="border: 1px solid deeppink;">
            <!-- Replace the content with your name and email address -->
            <div class="col-sm-6" style="text-align: left;">
                <p>Copyright &copy; David Matos</p>
            </div>
            <div class="col-sm-6" style="text-align: right;">
                <p>Contact us: st20177569@cardiffmet.ac.uk</p>
            </div>
        </div>
    </footer>

    <script>
    </script>
</body>

</html>