<?php
// session handling PHP code
session_start();
if (!isset($_SESSION["user_id"])) {
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



</head>

<body>
    <main class="container" style="width: auto; height: auto;">
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
                    <!-- <td>
                    <div style="float: right;">
                        <img alt="Main Car Photo" src="http://CardiffMetCarSales/userImages/<?php echo $_SESSION["username"] ?>/profilePicture-cardiff-met-uni-logo" width="33%">
                        <h4> Welcome <a href="#"> <?php echo $_SESSION["username"];  ?> </a> <a href="logout.php"> Logout </a> </h4>
                        <hr>
                    </div>
                </td> -->
                </tr>
            </table>
        </header>

        <div class="navBar" id="myTopnav">
            <a href="http://CardiffMetCarSales/index">Home</a>
            <a href="http://CardiffMetCarSales/findCars">Find Cars</a>
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

                $sql = "SELECT * FROM vehicle_details WHERE vehicle_id=?";

                $stmt = $conn->prepare($sql);

                $stmt->bind_param("i", $_GET["vehicle_id"]);
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
                    echo $_GET["vehicle_id"];
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

                                <div class="col-sm-4">
                                    <div style="padding-bottom: 27px;">
                                        Vehicle Make
                                        <input type="text" value="<?php echo $row["vehicle_make"]; ?>" readonly name="vehicleMake" style="width: 100%;">

                                    </div>
                                    <div style="padding-bottom: 27px;">
                                        Vehicle Model
                                        <input type="text" value="<?php echo $row["vehicle_model"]; ?>" readonly name="vehicleModel" style="width: 100%;">
                                    </div>
                                    <div style="padding-bottom: 27px;">
                                        Vehicle Bodytype
                                        <input type="text" value="<?php echo $row["vehicle_bodytype"]; ?>" readonly name="vehicleBodytype" style="width: 100%;">
                                    </div>
                                    <div style="padding-bottom: 27px;">
                                        Fuel Type
                                        <input type="text" value="<?php echo $row["fuel_type"]; ?>" readonly name="fuelType" style="width: 100%;">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div style="padding-bottom: 27px;">
                                        Mileage
                                        <input type="text" value="<?php echo $row["mileage"]; ?>" readonly name="mileage" style="width: 100%;">
                                    </div>
                                    <div style="padding-bottom: 27px;">
                                        Location
                                        <input type="text" value="<?php echo $row["location"]; ?>" readonly name="location" style="width: 100%;">
                                    </div>
                                    <div style="padding-bottom: 27px;">
                                        Year
                                        <input type="text" value="<?php echo $row["year"]; ?>" readonly name="year" style="width: 100%;">
                                    </div>
                                    <div style="padding-bottom: 27px;">
                                        Number of Doors
                                        <input type="number" value="<?php echo $row["num_doors"]; ?>" readonly name="numDoor" style="width: 100%;">
                                    </div>
                                </div>
                            </section>
                            <section class="row col-12">
                                <div class="col-sm-4">
                                    <?php
                                    $tempDir = $row["image_url"];

                                    $path = "$tempDir\\carPicture2";
                                    $files = opendir($path);
                                    if ($files) {
                                        while (($fileName = readdir($files)) == true) {
                                            if ($fileName != '.' && $fileName != '..') {
                                                $photo = "http://CardiffMetCarSales/" . $tempDir . "carPicture2/" . $fileName;
                                            }
                                        }
                                    }
                                    ?>
                                    <div>
                                        <img alt="Car Picture" src="<?php echo $photo; ?>" width="100%" height="125px" style="padding-bottom: 20px;">
                                    </div>
                                    <?php
                                    $tempDir = $row["image_url"];

                                    $path = "$tempDir\\carPicture3";
                                    $files = opendir($path);
                                    if ($files) {
                                        while (($fileName = readdir($files)) == true) {
                                            if ($fileName != '.' && $fileName != '..') {
                                                $photo = "http://CardiffMetCarSales/" . $tempDir . "carPicture3/" . $fileName;
                                            }
                                        }
                                    }
                                    ?>
                                    <div>
                                        <img alt="Car Picture" src="<?php echo $photo; ?>" width="100%" height="125px" style="padding-bottom: 20px;">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <?php
                                    $tempDir = $row["image_url"];

                                    $path = "$tempDir\\carPicture4";
                                    $files = opendir($path);
                                    if ($files) {
                                        while (($fileName = readdir($files)) == true) {
                                            if ($fileName != '.' && $fileName != '..') {
                                                $photo = "http://CardiffMetCarSales/" . $tempDir . "carPicture4/" . $fileName;
                                            }
                                        }
                                    }
                                    ?>
                                    <div>
                                        <img alt="Car Picture" src="<?php echo $photo; ?>" width="100%" height="125px" style="padding-bottom: 20px;">
                                    </div>
                                    <?php
                                    $tempDir = $row["image_url"];

                                    $path = "$tempDir\\carPicture5";
                                    $files = opendir($path);
                                    if ($files) {
                                        while (($fileName = readdir($files)) == true) {
                                            if ($fileName != '.' && $fileName != '..') {
                                                $photo = "http://CardiffMetCarSales/" . $tempDir . "carPicture5/" . $fileName;
                                            }
                                        }
                                    }
                                    ?>
                                    <div>
                                        <img alt="Car Picture" src="<?php echo $photo; ?>" width="100%" height="125px" style="padding-bottom: 20px;">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div style="text-align: center; padding-top: 100px;">
                                        <a href="http://CardiffMetCarSales/index">
                                            <input type="submit" style="font-size: 30px; background-color: #99FF99;" value="BUY NOW!">
                                        </a>
                                    </div>
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
    </main>
</body>

</html>