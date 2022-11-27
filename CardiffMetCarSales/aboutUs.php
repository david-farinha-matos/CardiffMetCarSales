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
        <a href="http://CardiffMetCarSales/aboutUs" class="currentPage">About Us</a>
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

    <div class="row col-12">
        <div class="col-sm-4">
            <p>Hello, my name is David Matos and I created this website. I am a Computer Science student studying at Cardiff Met Uni. I hope to increase my knowledge within computer science and hope I can make a gooid future using this degree.</p>
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
    </div>

    <div class="row col-12">
        <div class="col-sm-4">
            <p style="text-align: center; font-size: 2.3em;">
                Llandaff Campus, <br> Western Ave, <br> Cardiff, <br>CF5 2YB
            </p>
        </div>
        <div class="col-sm-8" style="text-align: center;">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2483.9523074784975!2d-3.21470868423043!3d51.495742679633246!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x486e1cc7d35d3eef%3A0x5afe25c130d18e76!2sCardiff%20Metropolitan%20University!5e0!3m2!1sen!2suk!4v1622053962403!5m2!1sen!2suk" width="100%" height="250px" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>
</body>

</html>