<?php 
session_start();
// check if user is logged in
if(!isset($_SESSION["userid"])){
    header("location: userlogin.php");
}

session_unset();
session_destroy();

// re-directs to index page
header('location: index.php');

?>