<?php
// session handling PHP code
session_start();
if (!isset($_SESSION["username"])) {
    header("location: index.php");
}

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

    <!-- <style>
        .signup {
            border: 1px solid #999999;
            font: normal 14px helvetica;
            color: #444444;
        }
    </style> -->


</head>

<body>
    <!-- Header -->
    <header class="bgColour">

        <table>
            <tr>
                <td>
                    <div class="logo">
                        <img src="http://CardiffMetCarSales/images-used/cardiff-met-uni-logo.jpg"></img>
                    </div>
                </td>
                <td style="font-size: 6vw; text-align:right;">CardiffMetCarSales</td>
            </tr>
        </table>
    </header>

    <div class="navBar" id="myTopnav">
        <a href="http://CardiffMetCarSales/index">Home</a>
        <a href="http://CardiffMetCarSales/findCars" class="currentPage">Find Cars</a>
        <a href="http://CardiffMetCarSales/sellCars">Sell Cars</a>
        <a href="http://CardiffMetCarSales/myCars">My Cars</a>
        <a href="http://CardiffMetCarSales/aboutUs">About Us</a>
        <a href="http://CardiffMetCarSales/registration">Register</a>
    </div>



    <section class="row">
        <div class="col-12" style="float: right; padding-right: 5%;">
            <?php

            $username = $_SESSION["username"];

            $dirPath = "userImages/$username";
            $files = opendir($dirPath);
            if ($files) {
                while (($fileName = readdir($files)) !== FALSE) {
                    if ($fileName != '.' && $fileName != '..') {
                        $photo = "http://cardiffmetcarsales/userImages/" . $username . "/" . $fileName;
                    }
                }
            }
            ?>
            <img src=<?php echo $photo; ?> style="width: 50px; height:50px;">
            <h4> Welcome <a href="allusermodules.php"> <?php echo $_SESSION["username"];  ?> </a> <a href="logout.php"> Logout </a> </h4>
            <hr>
        </div>
    </section>

    <section class="row">
        <?php

        $dbConnectionError = "";
        // Create connection
        $conn = new mysqli($servername, $dbusername, $dbpassword, $databasename, 3306);

        // Check connection
        if ($conn->connect_error) { // connection check if condition
            die("Connection failed: " . $conn->connect_error);

        ?>

            <div class="col-12 error" style="background-color: lightred; border: 2px hidden white; border-radius: 3px;">
                <h3> Error while connecting to the MySQL database! </h3>
            </div>

            <?php

        } // end of connection check. 
        else {

            $sql = "SELECT * FROM vehicle_details";

            $stmt = $conn->prepare($sql);

            // execute the SQL 
            $stmt->execute();

            $result = $stmt->get_result();

            if ($result->num_rows <= 0) { // check if any vehicles are available for the current user
            ?>
                <div class="col-12 error" style="background-color: lightred; border: 2px hidden white; border-radius: 3px; padding-left: 20px;">
                    <h3> No data available for the user </h3>
                </div>

            <?php
            } // num rows if            
            else {
            ?>
                <div class="col-12">
                    <?php
                    while ($row = $result->fetch_assoc()) { // begin while loop
                    ?>
                        <section class="row col-12">
                            <div class="col-sm-4">
                                <?php
                                $tempDir = $row["image_url"];

                                $path = "$tempDir\\carPicture1";
                                $files = opendir($path);
                                if ($files) {
                                    while (($fileName = readdir($files)) == true) {
                                        if ($fileName != '.' && $fileName != '..') {
                                            $photo = "http://CardiffMetCarSales/" . $tempDir . "carPicture1/" . $fileName;
                                        }
                                    }
                                }
                                ?>
                                <div>
                                    <img alt="Car Picture" src="<?php echo $photo; ?>" width="100%" style="padding-bottom: 20px;">
                                </div>
                            </div>
                            <div class="col-sm-4" style="text-align: center; font-size: 2em;">
                                <p>
                                    Make:
                                    <?php echo $row["vehicle_make"]; ?> <br>
                                    Model:
                                    <?php echo $row["vehicle_model"]; ?> <br>
                                    Mileage:
                                    <?php echo $row["mileage"]; ?> <br>
                                </p>
                            </div>
                            <div class="col-sm-4" style="text-align: center;">
                                <a style="font-size: 2.3em; text-align: center;" href="viewVehicle.php?vehicle_id=<?php echo $row['vehicle_id'] ?>"> View </a>
                            </div>
                        </section>
                    <?php
                    } // end while loop
                    ?>
            <?php
            } //end of rows else
        } // end of connection else

        $conn->close();
            ?>
    </section>

</body>