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
            <a href="http://CardiffMetCarSales/sellCars" class="currentPage">Sell Cars</a>
            <a href="http://CardiffMetCarSales/myCars">My Cars</a>
            <a href="http://CardiffMetCarSales/aboutUs">About Us</a>
            <a href="http://CardiffMetCarSales/registration">Register</a>
        </div>
        <section class="col-sm-12">
            <div class="col-sm-2" style="float: right;">

                <?php
                $username = $_SESSION["username"];

                $dirPath = "userImages/$username";
                $files = opendir($dirPath);
                if ($files) {
                    while (($fileName = readdir($files)) !== FALSE) {
                        if ($fileName != '.' && $fileName != '..') {
                            $photo = "http://CardiffMetCarSales/userImages/" . $username . "/" . $fileName;
                        }
                    }
                }
                ?>
                <img alt="Profile Picture" src="<?php echo $photo; ?>" width="50px" height="50px">
                <h4> Welcome <a href="#"> <?php echo $_SESSION["username"];  ?> </a> <a href="logout.php"> Logout </a> </h4>
            </div>
        </section>

        <?php
        // defining variables to set empty values
        $vehicleMake = $vehicleModel = $vehicleBodytype = $fuelType = $mileage = $location = $year = $numDoor = "";
        $addCarPic1 = $addCarPic2 = $addCarPic3 = $addCarPic4 = $addCarPic5 = "";
        //declare variables to hold error messages 
        $vehicleMakeError = $vehicleModelError = $vehicleBodytypeError = $fuelTypeError = $mileageError = $locationError = $yearError = $numDoorError = $carPicError = $carPicError2 = $carPicError3 = $carPicError4 = $carPicError5 = "";
        // if the form has been submitted, AND the method is POST
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
             $counter = 0;
            if (empty($_POST["vehicleMake"])) {
                $vehicleMakeError = "A vehicle make is required";
            } else {
                if (!preg_match("/^[a-zA-Z ]*$/", $_POST["vehicleMake"])) {
                    $vehicleMakeError = "Only letters allowed";
                } else {
                    $vehicleMake = clearUserInputs($_POST["vehicleMake"]);
                }
            }
            if (empty($_POST["vehicleModel"])) {
                $vehicleModelError = "A vehicle model is required";
            } else {
                $vehicleModel = clearUserInputs($_POST["vehicleModel"]);
            }

            if (empty($_POST["vehicleBodytype"])) {
                $vehicleBodytypeError = "A vehicle bodytype is required";
            } else {
                $vehicleBodytype = clearUserInputs($_POST["vehicleBodytype"]);
            }
            if (empty($_POST["mileage"])) {
                $mileageError = "Mileage is required";
            } else {
                if (!preg_match("/^[0-9]*$/", $_POST["mileage"])) {
                    $mileageError = "Only Numbers can be input ";
                } else {
                    $mileage = clearUserInputs($_POST["mileage"]);
                }

                if (empty($_POST["fuelType"])) {
                    $fuelTypeError = "fuel type is required";
                } else {
                    $fuelType = clearUserInputs($_POST["fuelType"]);
                }

                if (empty($_POST["location"])) {
                    $locationError = "location is required";
                } else {
                    $location = clearUserInputs($_POST["location"]);
                }
                if (empty($_POST["year"])) {
                    $yearError = "The vehicle's Year is required";
                } else {
                    if (!preg_match("/^[0-9]*$/", $_POST["year"])) {
                        $yearError = "Only Numbers can be input ";
                    } else {
                        $year = clearUserInputs($_POST["year"]);
                    }
                    if (empty($_POST["numDoor"])) {
                        $numDoorError = "Number of door is required";
                    } else {
                        $numDoor = clearUserInputs($_POST["numDoor"]);
                    }
                }
            }



            $image1ok = false;
            $image2ok = false;
            $image3ok = false;
            $image4ok = false;
            $image5ok = false;
            //$counter = 0;

            //extract selected file details:
            $file_name = $_FILES['addCarPic1']['name'];
            $file_size = $_FILES['addCarPic1']['size'];
            $file_tmp = $_FILES['addCarPic1']['tmp_name'];
            $file_type = $_FILES['addCarPic1']['type'];
            $basename_file = basename($_FILES["addCarPic1"]["name"]);
            $file_ext = strtolower(pathinfo($basename_file, PATHINFO_EXTENSION));

            $allowed_extensions = array("jpeg", "jpg", "png");

            echo $file_size;
            if ($file_size > 2000000 || $file_size == 0) {
                $carPicError .=  "Sorry, your file is too large. <br>";
                $counter = $counter + 1;
                $image1ok = false;
            } else if (in_array($file_ext, $allowed_extensions) === false) {
                $carPicError .=  "Only JPEG, PNG and JPG files are allowed <br>";
                $counter = $counter + 1;
                $image1ok = false;
            } else {
                $image1ok = true;
            }

            $file_name = $_FILES['addCarPic2']['name'];
            $file_size2 = $_FILES['addCarPic2']['size'];
            $file_tmp = $_FILES['addCarPic2']['tmp_name'];
            $file_type = $_FILES['addCarPic2']['type'];
            $basename_file = basename($_FILES["addCarPic2"]["name"]);
            $file_ext = strtolower(pathinfo($basename_file, PATHINFO_EXTENSION));

            $allowed_extensions = array("jpeg", "jpg", "png");

            echo $file_size2;
            if ($file_size2 > 2000000 || $file_size == 0) {
                $carPicError2 .=  "Sorry, your file is too large. <br>";
                $counter = $counter + 1;
                $image2ok = false;
                header ("location: sellCars.php");
            } else if (in_array($file_ext, $allowed_extensions) === false) {
                $carPicError2 .=  "Only JPEG, PNG and JPG files are allowed <br>";
                $counter = $counter + 1;
                $image2ok = false;
            } else {
                $image2ok = true;
            }

            $file_name = $_FILES['addCarPic3']['name'];
            $file_size3 = $_FILES['addCarPic3']['size'];
            $file_tmp = $_FILES['addCarPic3']['tmp_name'];
            $file_type = $_FILES['addCarPic3']['type'];
            $basename_file = basename($_FILES["addCarPic3"]["name"]);
            $file_ext = strtolower(pathinfo($basename_file, PATHINFO_EXTENSION));

            $allowed_extensions = array("jpeg", "jpg", "png");

            echo $file_size3;
            if ($file_size3 > 2000000 || $file_size == 0) {
                $carPicError3 .=  "Sorry, your file is too large. <br>";
                $counter = $counter + 1;
                $image3ok = false;
            } else if (in_array($file_ext, $allowed_extensions) === false) {
                $carPicError3 .=  "Only JPEG, PNG and JPG files are allowed <br>";
                $counter = $counter + 1;
                $image3ok = false;
            } else {
                $image3ok = true;
            }

            $file_name = $_FILES['addCarPic4']['name'];
            $file_size4 = $_FILES['addCarPic4']['size'];
            $file_tmp = $_FILES['addCarPic4']['tmp_name'];
            $file_type = $_FILES['addCarPic4']['type'];
            $basename_file = basename($_FILES["addCarPic4"]["name"]);
            $file_ext = strtolower(pathinfo($basename_file, PATHINFO_EXTENSION));

            $allowed_extensions = array("jpeg", "jpg", "png");

            echo $file_size4;
            if ($file_size4 > 2000000 || $file_size == 0) {
                $carPicError4 .=  "Sorry, your file is too large. <br>";
                $counter = $counter + 1;
                $image4ok = false;
            } else if (in_array($file_ext, $allowed_extensions) === false) {
                $carPicError4 .=  "Only JPEG, PNG and JPG files are allowed <br>";
                $counter = $counter + 1;
                $image4ok = false;
            } else {
                $image4ok = true;
            }

            $file_name = $_FILES['addCarPic5']['name'];
            $file_size5 = $_FILES['addCarPic5']['size'];
            $file_tmp = $_FILES['addCarPic5']['tmp_name'];
            $file_type = $_FILES['addCarPic5']['type'];
            $basename_file = basename($_FILES["addCarPic5"]["name"]);
            $file_ext = strtolower(pathinfo($basename_file, PATHINFO_EXTENSION));

            $allowed_extensions = array("jpeg", "jpg", "png");

            echo $file_size5;
            if ($file_size5 > 2000000 || $file_size == 0) {
                $carPicError5 .=  "Sorry, your file is too large. <br>";
                $counter = $counter + 1;
                $image5ok = false;
            } else if (in_array($file_ext, $allowed_extensions) === false) {
                $carPicError5 .=  "Only JPEG, PNG and JPG files are allowed <br>";
                $counter = $counter + 1;
                $image5ok = false;
            } else {
                $image5ok = true;
            }

            echo $counter;

            // if ($counter > 0) {
            //     header ("location: sellCars.php");
            // }

            if ($image1ok == true && $image2ok == true && $image3ok == true && $image4ok == true && $image5ok == true) {

                // Create connection
                $conn = new mysqli(
                    $servername,
                    $dbusername,
                    $dbpassword,
                    $databasename,
                    3306
                );

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);

        ?>
                    <div class="col-12 error" style="background-color: lightred; border: 2px hidden white; border-radius: 3px;">
                        <h3> Error while connecting to the MySQL database! </h3>
                    </div>
        <?php

                } else {

                    echo "Connected successfully \n";

                    $newFolderDir = "userImages\\$username-Cars\\"; // relative path is needed

                    $sql = "INSERT INTO vehicle_details
                (   user_id,
                    vehicle_make,
                    vehicle_model,
                    vehicle_bodytype,
                    fuel_type,
                    mileage,
                    location,
                    year,
                    num_doors,
                    image_url)
                values(?, ?, ?, ? , ?, ?, ?, ?, ?, ?)";

                    $stmt = $conn->prepare($sql);
                    // make a variable for user id then bind it with parameters for SQL
                    // bind params
                    $stmt->bind_param(
                        "ssssssssis",
                        $_SESSION["user_id"],
                        $vehicleMake,
                        $vehicleModel,
                        $vehicleBodytype,
                        $fuelType,
                        $mileage,
                        $location,
                        $year,
                        $numDoor,
                        $newFolderDir
                    );

                    // execute the SQL 
                    $stmt->execute();

                    // retrieve number of affected rows
                    $res = $conn->affected_rows;

                    // if a record insert is successfull, $res will be > 0
                    if ($res > 0) {
                        $last_id = $conn->insert_id;
                        echo "New record created successfully. Last inserted ID is: " . $last_id;
                    } else {
                        echo "Error occurred while inserting record " . $res . " Error: " . $conn->error . " \n";
                    }

                    if (!file_exists($newFolderDir)) {
                        mkdir($newFolderDir, 0777, true);
                        $folderForCar1 = "$newFolderDir\\carPicture1";
                        mkdir($folderForCar1, 0777, true);
                        $targetPath = $folderForCar1 . "/carPicture1-";
                        $img = $_FILES['addCarPic1']['name'];
                        $img_loc = $_FILES['addCarPic1']['tmp_name'];
                        move_uploaded_file($img_loc, $targetPath . $img);
                    } else {
                        $folderForCar1 = "$newFolderDir\\carPicture1";
                        mkdir($folderForCar1, 0777, true);
                        $targetPath = $folderForCar1 . "/carPicture1-";
                        $img = $_FILES['addCarPic1']['name'];
                        $img_loc = $_FILES['addCarPic1']['tmp_name'];
                        move_uploaded_file($img_loc, $targetPath . $img);
                    }

                    if (!file_exists($newFolderDir)) {
                        mkdir($newFolderDir, 0777, true);
                        $folderForCar2 = "$newFolderDir\\carPicture2";
                        mkdir($folderForCar2, 0777, true);
                        $targetPath = $folderForCar2 . "/carPicture2-";
                        $img = $_FILES['addCarPic2']['name'];
                        $img_loc = $_FILES['addCarPic2']['tmp_name'];
                        move_uploaded_file($img_loc, $targetPath . $img);
                    } else {
                        $folderForCar2 = "$newFolderDir\\carPicture2";
                        mkdir($folderForCar2, 0777, true);
                        $targetPath = $folderForCar2 . "/carPicture2-";
                        $img = $_FILES['addCarPic2']['name'];
                        $img_loc = $_FILES['addCarPic2']['tmp_name'];
                        move_uploaded_file($img_loc, $targetPath . $img);
                    }

                    if (!file_exists($newFolderDir)) {
                        mkdir($newFolderDir, 0777, true);
                        $folderForCar3 = "$newFolderDir\\carPicture3";
                        mkdir($folderForCar3, 0777, true);
                        $targetPath = $folderForCar3 . "/carPicture3-";
                        $img = $_FILES['addCarPic3']['name'];
                        $img_loc = $_FILES['addCarPic3']['tmp_name'];
                        move_uploaded_file($img_loc, $targetPath . $img);
                    } else {
                        $folderForCar3 = "$newFolderDir\\carPicture3";
                        mkdir($folderForCar3, 0777, true);
                        $targetPath = $folderForCar3 . "/carPicture3-";
                        $img = $_FILES['addCarPic3']['name'];
                        $img_loc = $_FILES['addCarPic3']['tmp_name'];
                        move_uploaded_file($img_loc, $targetPath . $img);
                    }

                    if (!file_exists($newFolderDir)) {
                        mkdir($newFolderDir, 0777, true);
                        $folderForCar4 = "$newFolderDir\\carPicture4";
                        mkdir($folderForCar4, 0777, true);
                        $targetPath = $folderForCar4 . "/carPicture4-";
                        $img = $_FILES['addCarPic4']['name'];
                        $img_loc = $_FILES['addCarPic4']['tmp_name'];
                        move_uploaded_file($img_loc, $targetPath . $img);
                    } else {
                        $folderForCar4 = "$newFolderDir\\carPicture4";
                        mkdir($folderForCar4, 0777, true);
                        $targetPath = $folderForCar4 . "/carPicture4-";
                        $img = $_FILES['addCarPic4']['name'];
                        $img_loc = $_FILES['addCarPic4']['tmp_name'];
                        move_uploaded_file($img_loc, $targetPath . $img);
                    }


                    if (!file_exists($newFolderDir)) {
                        mkdir($newFolderDir, 0777, true);
                        $folderForCar5 = "$newFolderDir\\carPicture5";
                        mkdir($folderForCar5, 0777, true);
                        $targetPath = $folderForCar5 . "/carPicture5-";
                        $img = $_FILES['addCarPic5']['name'];
                        $img_loc = $_FILES['addCarPic5']['tmp_name'];
                        move_uploaded_file($img_loc, $targetPath . $img);
                    } else {
                        $folderForCar5 = "$newFolderDir\\carPicture5";
                        mkdir($folderForCar5, 0777, true);
                        $targetPath = $folderForCar5 . "/carPicture5-";
                        $img = $_FILES['addCarPic5']['name'];
                        $img_loc = $_FILES['addCarPic5']['tmp_name'];
                        move_uploaded_file($img_loc, $targetPath . $img);
                    }
                }
                $stmt->close();
                $conn->close();

                // header("location: myCars.php");
            }
        }
        // function to clear userinputs
        function clearUserInputs($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        ?>


        <!-- <table border="0" cellpadding="20" cellspacing="5" style="background-color:#f5f5f5" align="center"> -->
        <!-- <th colspan="2" style="text-align:center">Sell Car</th> -->
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
            <form method="post" action="index-2.html" onsubmit="return validate(this);">
                <section class="row col-12">
                    <div class="col-sm-4">
                        <script>
                            var openFile1 = function(file) {
                                var input = file.target;

                                var reader = new FileReader();
                                reader.onload = function() {
                                    var dataURL = reader.result;
                                    var output = document.getElementById('addCarPic1');
                                    output.src = dataURL;
                                };
                                reader.readAsDataURL(input.files[0]);
                            };
                        </script>
                        <input type='file' name="addCarPic1" onchange='openFile1(event)'><br>
                        <img id='addCarPic1' style="height: 250px; width:100%;">
                        <span class="error"> * <?php echo $carPicError ?> </span>

                    </div>
                    <div class="col-sm-4">
                        <div style="padding-bottom: 27px;">
                            Vehicle Make
                            <input type="text" maxlength="32" name="vehicleMake" style="width: 100%;">
                            <span> <?php echo $vehicleMakeError;  ?> </span>
                        </div>
                        <div style="padding-bottom: 27px;">
                            Vehicle Model
                            <input type="text" maxlength="32" name="vehicleModel" style="width: 100%;">
                            <span> <?php echo $vehicleModelError;  ?> </span>
                        </div>
                        <div style="padding-bottom: 27px;">
                            Vehicle Bodytype
                            <input type="text" maxlength="32" name="vehicleBodytype" style="width: 100%;">
                            <span> <?php echo $vehicleBodytypeError;  ?> </span>
                        </div>
                        <div style="padding-bottom: 27px;">
                            Fuel Type
                            <input type="text" maxlength="32" name="fuelType" style="width: 100%;">
                            <span> <?php echo $fuelTypeError;  ?> </span>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div style="padding-bottom: 27px;">
                            Mileage
                            <input type="text" maxlength="32" name="mileage" style="width: 100%;">
                            <span> <?php echo $mileageError;  ?> </span>
                        </div>
                        <div style="padding-bottom: 27px;">
                            Location
                            <input type="text" maxlength="32" name="location" style="width: 100%;">
                            <span> <?php echo $locationError;  ?> </span>
                        </div>
                        <div style="padding-bottom: 27px;">
                            Year
                            <input type="text" maxlength="32" name="year" style="width: 100%;">
                            <span> <?php echo $yearError;  ?> </span>
                        </div>
                        <div style="padding-bottom: 27px;">
                            Number of Doors
                            <input type="number" max="8" name="numDoor" style="width: 100%;">
                            <span> <?php echo $numDoorError;  ?> </span>
                        </div>
                    </div>
                </section>
                <br>
                <section class="row col-12">

                    <div class="col-sm-4">
                        <div style="width: 100%;">
                            <script>
                                var openFile2 = function(file) {
                                    var input = file.target;

                                    var reader = new FileReader();
                                    reader.onload = function() {
                                        var dataURL = reader.result;
                                        var output = document.getElementById('addCarPic2');
                                        output.src = dataURL;
                                    };
                                    reader.readAsDataURL(input.files[0]);
                                };
                            </script>
                            <input type='file' name="addCarPic2" onchange='openFile2(event)'><br>
                            <img id='addCarPic2' style="height: 125px; width:100%;">
                            <span class="error"> * <?php echo $carPicError2 ?> </span>
                        </div>
                        <br>
                        <div style="width: 100%;">
                            <script>
                                var openFile3 = function(file) {
                                    var input = file.target;

                                    var reader = new FileReader();
                                    reader.onload = function() {
                                        var dataURL = reader.result;
                                        var output = document.getElementById('addCarPic3');
                                        output.src = dataURL;
                                    };
                                    reader.readAsDataURL(input.files[0]);
                                };
                            </script>
                            <input type='file' name="addCarPic3" onchange='openFile3(event)'><br>
                            <img id='addCarPic3' style="height: 125px; width: 100%;">
                            <span class="error"> * <?php echo $carPicError3 ?> </span>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div style="width: 100%;">
                            <script>
                                var openFile4 = function(file) {
                                    var input = file.target;

                                    var reader = new FileReader();
                                    reader.onload = function() {
                                        var dataURL = reader.result;
                                        var output = document.getElementById('addCarPic4');
                                        output.src = dataURL;
                                    };
                                    reader.readAsDataURL(input.files[0]);
                                };
                            </script>
                            <input type='file' name="addCarPic4" onchange='openFile4(event)'><br>
                            <img id='addCarPic4' style="height: 125px; width: 100%;">
                            <span class="error"> * <?php echo $carPicError4 ?> </span>
                        </div>
                        <br>
                        <div style="width: 100%;">
                            <script>
                                var openFile5 = function(file) {
                                    var input = file.target;

                                    var reader = new FileReader();
                                    reader.onload = function() {
                                        var dataURL = reader.result;
                                        var output = document.getElementById('addCarPic5');
                                        output.src = dataURL;
                                    };
                                    reader.readAsDataURL(input.files[0]);
                                };
                            </script>
                            <input type='file' name="addCarPic5" onchange='openFile5(event)'><br>
                            <img id='addCarPic5' style="height: 125px; width: 100%;">
                            <span class="error"> * <?php echo $carPicError5 ?> </span>
                        </div>
                    </div>
                    <div class="col-sm-4" style="text-align: center; padding-top: 100px;">
                        <input type="submit" style="font-size: 30px;" value="Sell Car">
                    </div>
                </section>

            </form>
        </form>
    </main>
</body>

</html>