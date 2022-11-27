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

            /**
             * If the request is POST, get the new values from form and update the table. 
             */

            $dbConnectionError = "";

            $vehicleMake = $vehicleModel = $vehicleBodytype = $fuelType = $mileage = $location = $year = $numDoor = "";

            $conn = new mysqli($servername, $dbusername, $dbpassword, $databasename, 3308);

            // Check connection
            if ($conn->connect_error) {
                $dbConnectionError = "Error in connecting to the database!";
                die("Connection failed: " . $conn->connect_error);
            ?>

                <div class="error" style="background-color: lightred; border: 2px hidden white; border-radius: 3px;">
                    <h3> Error while connecting to the MySQL database! </h3>
                </div>
                <?php
            } else {
                echo "connection is ok..";

                /**
                 * If the request is GET, select the current subject from DB and populate the form
                 */
                if ($_SERVER["REQUEST_METHOD"] == "GET") {

                    // Prepare SQL statements to select the subject record from DB
                    $sql = "SELECT * FROM vehicle_details WHERE vehicle_id=?";

                    $stmt = $conn->prepare($sql);

                    // bind params
                    $stmt->bind_param("s", $_GET["vehicle_id"]);

                    // execute the SQL 
                    $stmt->execute();

                    $result = $stmt->get_result();

                    if ($result->num_rows <= 0) {
                ?>
                        <div class="error" style="background-color: lightred; border: 2px hidden white; border-radius: 3px;">
                            <h3> No data available for the subject </h3>
                        </div>
            <?php
                    } else {
                        $row = $result->fetch_assoc();

                        // Get data to appropriate variables from $row. 
                        $vehicleMake = $row["vehicle_make"];
                        $vehicleModel = $row["vehicle_model"];
                        $vehicleBodytype = $row["vehicle_bodytype"];
                        $fuelType = $row["fuel_type"];
                        $mileage = $row["mileage"];
                        $location = $row["location"];
                        $year = $row["year"];
                        $numDoor = $row["num_doors"];
                    }
                } //end of get
            } // end of connection if. 

            ?>

            <?php
            /**
             * If the request is POST, get the new values from form and update the table. 
             */
            if ($_SERVER["REQUEST_METHOD"] == "POST") {

                // Use $_POST[] to get the values from the form.
                $vehicleMake = $_POST["vehicle_make"];
                $vehicleModel = $_POST["vehicle_model"];
                $vehicleBodytype = $_POST["vehicle_bodytype"];
                $fuelType = $_POST["fuel_type"];
                $mileage = $_POST["mileage"];
                $location = $_POST["location"];
                $year = $_POST["year"];
                $numDoor = $_POST["num_doors"];

                // if connection error..
                if ($conn->connect_error) {
            ?>
                    <div class="error" style="background-color: lightred; border: 2px hidden white; border-radius: 3px;">
                        <h3> Error while connecting to the MySQL database! </h3>
                    </div>

                    <?php
                } else {
                    echo "Connection is ok..";

                    /*
                UPDATE `subjects` SET `subject_name`=[value-3],`subject_aim`=[value-4],
                `indicative_content`=[value-5],`recommended_reading`=[value-6] where subject_id=7;
                */

                    // prepare SQL statements to update the record in the DB
                    $sql = "UPDATE vehicel_details SET vehicle_make=?, vehicle_model=?, vehicle_bodytype=?, fuel_type=?, mileage=?, location=?, year=?, num_doors=? WHERE vehicle_id=?";

                    $updatestmt = $conn->prepare($sql);

                    // bind params
                    $updatestmt->bind_param("sssssssi", $vehicleMake, $vehicleModel, $vehicleBodytype, $fuelType, $mileage, $location, $year, $numDoor);

                    // execute the SQL 
                    $updatestmt->execute();

                    $update_result = $updatestmt->get_result();

                    // if update is successfull.
                    if ($updatestmt->affected_rows > 0) {
                    ?>
                        <div class="error" style="background-color: lightred; border: 2px hidden white; border-radius: 3px;">
                            <h3> Record updated successfully </h3>
                        </div>
                    <?php
                    } else {
                    ?>
                        <div class="error" style="background-color: lightred; border: 2px hidden white; border-radius: 3px;">
                            <h3> Error while updating the record! </h3>
                        </div>
            <?php
                    }
                }
            }

            ?>

            <h2> Edit module form </h2>
            <span class="error" style="background-color: yello; color: red; font-size: 0.8em;"> <?php echo $dbConnectionError; ?> </span>
            <span class="error" style="background-color: yello; color: red; font-size: 0.8em;"> <?php echo $editError; ?> </span>

                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">


                <div class="col-sm-4">
                        <div style="padding-bottom: 27px;">
                            Vehicle Make
                            <input type="text" maxlength="32" name="vehicleMake" style="width: 100%;" <?php echo $vehicleMake; ?>>
                            <span> <?php echo $vehicleMakeError;  ?> </span>
                        </div>
                        <div style="padding-bottom: 27px;">
                            Vehicle Model
                            <input type="text" maxlength="32" name="vehicleModel" style="width: 100%;" <?php echo $vehicleModel; ?>>
                            <span> <?php echo $vehicleModelError;  ?> </span>
                        </div>
                        <div style="padding-bottom: 27px;">
                            Vehicle Bodytype
                            <input type="text" maxlength="32" name="vehicleBodytype" style="width: 100%;"<?php echo $vehicleBodytype; ?> >
                            <span> <?php echo $vehicleBodytypeError;  ?> </span>
                        </div>
                        <div style="padding-bottom: 27px;">
                            Fuel Type
                            <input type="text" maxlength="32" name="fuelType" style="width: 100%;"<?php echo $fuelType; ?>>
                            <span> <?php echo $fuelTypeError;  ?> </span>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div style="padding-bottom: 27px;">
                            Mileage
                            <input type="text" maxlength="32" name="mileage" style="width: 100%;"<?php echo $mileage; ?>>
                            <span> <?php echo $mileageError;  ?> </span>
                        </div>
                        <div style="padding-bottom: 27px;">
                            Location
                            <input type="text" maxlength="32" name="location" style="width: 100%;"<?php echo $location; ?>>
                            <span> <?php echo $locationError;  ?> </span>
                        </div>
                        <div style="padding-bottom: 27px;">
                            Year
                            <input type="text" maxlength="32" name="year" style="width: 100%;"<?php echo $year; ?>>
                            <span> <?php echo $yearError;  ?> </span>
                        </div>
                        <div style="padding-bottom: 27px;">
                            Number of Doors
                            <input type="number" max="8" name="numDoor" style="width: 100%;"<?php echo $numDoor; ?>>
                            <span> <?php echo $numDoorError;  ?> </span>
                        </div>
                        <div>
                        <input type="submit" value="Confirm Changes" />
                        </div>
                    </div>
                    <!-- <tr>
                        <td>User ID</td>
                        <td><input type="text" maxlength="32" name="user_id" value="<?php echo $user_id; ?>" readonly /></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Subject ID</td>
                        <td><input type="text" maxlength="32" name="subject_id" value="<?php echo $subject_id; ?>" readonly /></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Subject name</td>
                        <td><input type="text" maxlength="32" name="subject_name" value="<?php echo $subject_name; ?>" /> *</td>
                        <td><span class="error"> * <?php echo $subject_name_error; ?></span></td>
                    </tr>
                    <tr>
                        <td>Subject aim</td>
                        <td><textarea rows="4" cols="32" name="subject_aim"> <?php echo $subject_aim; ?> </textarea> *</td>
                        <td><span class="error"> * <?php echo $subject_aim_error; ?></span></td>
                    </tr>

                    <tr>
                        <td>Indicative content</td>
                        <td><textarea rows="4" cols="32" name="ind_content"> <?php echo $ind_content; ?> </textarea> *</td>
                        <td><span class="error"> * <?php echo $ind_content_error; ?></span></td>
                    </tr>
                    <tr>
                        <td>Recommended reading</td>
                        <td><textarea rows="4" cols="32" name="rec_reading"> <?php echo $rec_reading; ?> </textarea> *</td>
                        <td><span class="error"> * <?php echo $rec_reading_error; ?></span></td>
                    </tr>

                    <tr>
                        <td colspan="2" align="center">
                            <input type="submit" value="Edit subject" />
                        </td>
                    </tr> -->
                </form>
    </main>
</body>

</html>