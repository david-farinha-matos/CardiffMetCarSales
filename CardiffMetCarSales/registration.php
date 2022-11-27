<?php session_start();
require "connectionDB.php";
?>

<!-- <!DOCTYPE html> -->
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
        <a href="http://CardiffMetCarSales/findCars">Find Cars</a>
        <a href="http://CardiffMetCarSales/sellCars">Sell Cars</a>
        <a href="http://CardiffMetCarSales/myCars">My Cars</a>
        <a href="http://CardiffMetCarSales/aboutUs">About Us</a>
        <a href="http://CardiffMetCarSales/registration" class="currentPage">Register</a>
    </div>

    <script>
        function validate(form) {

            var fail = "";

            fail = validateForename(form.forename.value);
            fail += validateSurname(form.surname.value);

            if (fail == "") {
                return true;
            } else {
                alert(fail);
                return false;
            }
        }

        function validateForename(field) {
            return (field == "") ? "No Forename was entered.\n" : "";
        }

        function validateSurname(field) {
            if (field === "") {
                return "No Surname was entered.\n";
            } else {
                return "";
            }
            //return (field == "") ? "No Surname was entered." : "" this is the same as the if statement above
        }
    </script>

    <?php
    $title = $gender = $forename = $surname = $email = $username = $postcode = $adress1 = $adress2 = $adress3 = $phoneNumber = $password = $profilePicture = $description = "";

    // declare variable to store the error message
    $title_error = $gender_error = $forename_error = $surname_error = $email_error = $username_error = $postcode_error = $adress1_error = $adress2_error = $adress3_error = $phoneNumber_error = $password_error = $profilePicture_error = $description_error = "";
    $errorsFound = false;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // // access form data for processing
        // $title = clearUserInputs($_POST["title"]);
        // $gender = clearUserInputs($_POST["gender"]);
        // $forename = clearUserInputs($_POST["forename"]);
        // $surname = clearUserInputs($_POST["surname"]);
        // $email = clearUserInputs($_POST["email"]);
        // $username = clearUserInputs($_POST["username"]);
        // $postcode = clearUserInputs($_POST["postcode"]);
        // $phoneNumber = clearUserInputs($_POST["phoneNumber"]);
        // $password = clearUserInputs($_POST["password"]);






        if (preg_match('/[^A-Za-z]/i', $_POST["title"])) {
            $title_error = "No numbers or special characters are allowed";
            $errorsFound = true;
        } elseif (empty($_POST["title"])) {
            $title_error = "Title must not be empty";
            $errorsFound = true;
        } else {
            $title = clearUserInputs($_POST["title"]);
        }
        if (empty($_POST["gender"])) {
            $gender_error = "Gender must be selected";
            $errorsFound = true;
        } else {
            $gender = clearUserInputs($_POST["gender"]);
        }
        if (preg_match('/[^A-Za-z]/i', $_POST["forename"])) {
            $forename_error = "No numbers or special characters are allowed";
            $errorsFound = true;
        } elseif (empty($_POST["forename"])) {
            $forename_error = "Forename must not be empty";
            $errorsFound = true;
        } else {
            $forename = clearUserInputs($_POST["forename"]);
        }
        if (preg_match('/[^A-Za-z]/i', $_POST["surname"])) {
            $surname_error = "No numbers or special characters are allowed";
            $errorsFound = true;
        } elseif (empty($_POST["surname"])) {
            $surname_error = "Surname must not be empty";
            $errorsFound = true;
        } else {
            $surname = clearUserInputs($_POST["surname"]);
        }
        if (empty($_POST["email"])) {
            $email_error = "Email must not be empty";
            $errorsFound = true;
        } elseif (strpos($_POST["email"], '@') == false) {
            $email_error = "You are missing an @";
            $errorsFound = true;
        } elseif (strpos($_POST["email"], '.') == false) {
            $errorsFound = true;
            $email_error = "You are missing a .";
        } else {
            $email = clearUserInputs($_POST["email"]);
        }
        if (empty($_POST["username"])) {
            $username_error = "Username must not be empty";
            $errorsFound = true;
        } else {
            $username = clearUserInputs($_POST["username"]);
        }
        if (empty($_POST["postcode"])) {
            $postcode_error = "Postcode must not be empty";
            $errorsFound = true;
        } elseif (strlen($_POST["postcode"]) < 6) {
            $postcode_error = "Postcode should be atleast 6 characters";
            $errorsFound = true;
        } else {
            $postcode = clearUserInputs($_POST["postcode"]);
        }
        if (empty($_POST["adress1"])) {
            $adress1_error = "Address line 1 must not be empty";
            $errorsFound = true;
        } else {
            $adress1 = clearUserInputs($_POST["adress1"]);
        }
        if (empty($_POST["adress2"])) {
            $adress2_error = "Address line 2 must not be empty";
            $errorsFound = true;
        } else {
            $adress2 = clearUserInputs($_POST["adress2"]);
        }
        if (empty($_POST["adress3"])) {
            $adress3_error = "Address line 3 must not be empty";
            $errorsFound = true;
        } else {
            $adress3 = clearUserInputs($_POST["adress3"]);
        }
        if (empty($_POST["phoneNumber"])) {
            $phoneNumber_error = "Phone Number must not be empty";
            $errorsFound = true;
        } elseif ((preg_match('/[^0-9]/i', $_POST["phoneNumber"])) || (strlen($_POST["phoneNumber"]) != 11)) {
            $phoneNumber_error = "Phone number must only include numbers and must be 11 digets";
            $errorsFound = true;
        } else {
            $phoneNumber = clearUserInputs($_POST["phoneNumber"]);
        }
        if (empty($_POST["password"])) {
            $password_error = "Password must not be empty";
            $errorsFound = true;
        } elseif ((preg_match('/\d/', $_POST["password"])) && (preg_match('/\W/', $_POST["password"])) && (preg_match('/[a-zA-z]/', $_POST["password"])) && (strlen($_POST["password"]) >= 8)) {
            // $password_error = "Valid input";
            $password = clearUserInputs($_POST["password"]);
            $errorsFound = false;
        } else {
            $password_error = "Password requires atleast:\n -  8 Characters\n - 1 Number\n - 1 Special Character";
            $errorsFound = true;
        }
        if (empty($_POST["description"])) {
            $description_error = "Description must not be empty";
            $errorsFound = true;
        } else {
            $description = clearUserInputs($_POST["description"]);
        }


        //input file details  
        $imageok = false;

        // extract selected file details:
        $file_name = $_FILES['profilepicture']['name'];
        $file_size = $_FILES['profilepicture']['size'];
        $file_tmp = $_FILES['profilepicture']['tmp_name'];
        $file_type = $_FILES['profilepicture']['type'];
        $basename_file = basename($_FILES["profilepicture"]["name"]);
        $file_ext = strtolower(pathinfo($basename_file, PATHINFO_EXTENSION));

        // if ($file_size > 500000) {
        //     $profilePicture_error .=  "Sorry, your file is too large. <br>";
        //     $imageok = false;
        // } else if (in_array($file_ext, $allowed_extensions) === false) {
        //     $profilePicture_error .=  "Only JPEG, PNG and JPG files are allowed <br>";
        //     $imageok = false;
        // } else {
        //     $imageok = true;
        // }

        if ($errorsFound == false) {



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
            }
            echo "Connected successfully \n";

            $newFolderDir = "userImages/$username";


            // prepare SQL statements to insert data
            $sql = "INSERT INTO users 
            (username, 
            PASSWORD, 
            title, 
            first_name, 
            last_name, 
            gender, 
            adress1,
            adress2,
            adress3,
            postcode,
            description,
            email,
            telephone,
            profile_url)
            values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($sql);

            // bind params
            $stmt->bind_param("ssssssssssssss", $username, $password, $title, $forename, $surname, $gender, $adress1, $adress2, $adress3, $postcode, $description, $email, $phoneNumber, $newFolderDir);

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

                $targetPath = $newFolderDir . "/profilePicture-";

                $img = $_FILES['profilepicture']['name'];

                $img_loc = $_FILES['profilepicture']['tmp_name'];

                move_uploaded_file($img_loc, $targetPath . $img);
            }




            $_SESSION["username"] = $username;

            $stmt->close();
            $conn->close();
        }
    }

    // header("location: sellCars.php");


    // close the statements, and connection
    // $stmt->close();
    // $conn->close();

    //}

    //Function that clears all the text boxes
    function clearUserInputs($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);

        return $data;   // return cleaned user input

    }


    ?>

    <div class="col-sm-8">
        <table border="0" cellpadding="20" cellspacing="5" style="background-color:#f5f5f5" align="center">
            <th colspan="2" style="text-align:center">Signup Form</th>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                <form method="post" action="index-2.html" onsubmit="return validate(this);">
                    <tr>
                        <td>Title</td>
                        <td><input type="text" maxlength="6" name="title"></td>
                        <td><span> <?php echo $title_error;  ?> </span></td>
                    </tr>
                    <tr>
                        <td>Gender</td>
                        <td>
                            <input type="radio" name="gender" value="female" <?php if (isset($gender) && $gender == "female") echo "checked"; ?>>Female

                            <input type="radio" name="gender" value="male" <?php if (isset($gender) && $gender == "male") echo "checked"; ?>>Male

                        </td>
                        <td><span> <?php echo $gender_error ?> </span></td>
                    </tr>
                    <tr>
                        <td>Forename</td>
                        <td><input type="text" maxlength="32" name="forename"></td>
                        <td><span> <?php echo $forename_error;  ?> </span></td>
                    </tr>
                    <tr>
                        <td>Surname</td>
                        <td><input type="text" maxlength="32" name="surname"></td>
                        <td><span> <?php echo $surname_error;  ?> </span></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td><input type="text" maxlength="64" name="email"></td>
                        <td><span> <?php echo $email_error;  ?> </span></td>
                    </tr>
                    <tr>
                        <td>Username</td>
                        <td><input type="text" maxlength="16" name="username"></td>
                        <td><span> <?php echo $username_error;  ?> </span></td>
                    </tr>
                    <tr>
                        <td>Postcode</td>
                        <td><input type="text" maxlength="8" name="postcode"></td>
                        <td><span> <?php echo $postcode_error;  ?> </span></td>
                    </tr>
                    <tr>
                        <td>Address Line 1 (Address)</td>
                        <td><input type="text" maxlength="64" name="adress1"></td>
                        <td><span> <?php echo $adress1_error;  ?> </span></td>
                    </tr>
                    <tr>
                        <td>Address Line 2 (Town/City)</td>
                        <td><input type="text" maxlength="64" name="adress2"></td>
                        <td><span> <?php echo $adress2_error;  ?> </span></td>
                    </tr>
                    <tr>
                        <td>Address Line 3 (County)</td>
                        <td><input type="text" maxlength="64" name="adress3"></td>
                        <td><span> <?php echo $adress3_error;  ?> </span></td>
                    </tr>
                    <tr>
                        <td>Phone Number</td>
                        <td><input type="text" maxlength="11" name="phoneNumber"></td>
                        <td><span> <?php echo $phoneNumber_error;  ?> </span></td>
                    </tr>
                    <tr>
                        <td>Password</td>
                        <td><input type="text" maxlength="32" name="password"></td>
                        <td><span> <?php echo $password_error;  ?> </span></td>
                    </tr>
                    <tr>
                        <td>Profile Picture</td>
                        <td><input type="file" maxlength="64" name="profilepicture" id="profilepicture"></td>
                        <td><span class="error"> * <?php echo $profilePicture_error ?> </span></td>
                    </tr>
                    <tr>
                        <td>Descirption</td>
                        <td><input type="text" maxlength="64" name="description"></td>
                        <td><span> <?php echo $description_error;  ?> </span></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center">
                            <input type="submit" value="Signup">
                        </td>

                    </tr>
                </form>
        </table>
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
        <br>
        <br>
        <h1>Social Medias</h1>
        <div class="col-sm-2" style="width: 50%;">
            <a href="https://www.facebook.com/cardiff.metropolitan.university/">Facebook:
                <div>
                    <img alt="Facebook Logo" src="http://CardiffMetCarSales/images-used/Facebook-logo.png" style="width: 100%;">
                </div>
            </a>
        </div>
        <div class="col-sm-2" style="width: 50%;">
            <a href="https://twitter.com/cardiffmet?ref_src=twsrc%5Egoogle%7Ctwcamp%5Eserp%7Ctwgr%5Eauthor">Twitter:
                <div>
                    <img alt="Twitter Logo" src="http://CardiffMetCarSales/images-used/twitter-logo.jpg" style="width: 100%;">
                </div>
            </a>
        </div>
    </div>
</body>

</html>