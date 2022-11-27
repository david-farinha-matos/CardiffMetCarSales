<?php 
session_start();
// check session
if(!isset($_SESSION["user_id"])){
    header("location: index.php");
}

require "connectionDB.php";


// Create connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $databasename, 3306);

// Check connection
if ($conn->connect_error) {
    $dbConnectionError = "Error in connecting to the database!";
    die("Connection failed: " . $conn->connect_error);
}
else{

    if($_SERVER["REQUEST_METHOD"] == "GET"){

        $stmt = $conn->prepare("DELETE FROM vehicle_details WHERE vehicle_id= ?");

        $stmt->bind_param("i", $_GET["vehicle_id"]);
        $result = $stmt->execute();

        if($result && $stmt->affected_rows > 0){
            echo "Record deleted successfully!";
            header ("location: myCars.php");
        }
        else{
            echo "Error in deleting the record!";
        }
    }
    $stmt->close();
    $conn->close();
}
