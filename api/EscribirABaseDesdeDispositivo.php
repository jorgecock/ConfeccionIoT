<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//Creating Array for JSON response
$response = array();
 
// Check if we got the field from the user
if (isset($_GET['id']) && isset($_GET['Boton1']) && isset($_GET['Boton2'])    ) {
 
    $id = $_GET['id'];
    $Boton1= $_GET['Boton1'];
    $Boton2= $_GET['Boton2'];
 
    // Include data base connect class
    $filepath = realpath (dirname(__FILE__));
    require_once($filepath."/dbconnect.php");

    // Connecting to database
    $db = new DB_CONNECT();
 
    $con=mysqli_connect(DB_SERVER,DB_USER,DB_PASSWORD,DB_DATABASE);
        if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    // Fire SQL query to update LED status data by id
    $result = mysqli_query($con,"UPDATE led SET Boton1= '$Boton1',Boton2= '$Boton2' WHERE id = '$id'");
 
    // Check for succesfull execution of query and no results found
    if ($result) {
        // successfully updation of LED status (status)
        $response["success"] = 1;
        $response["message"] = "LED Status successfully updated.";
 
        // Show JSON response
        echo json_encode($response);
    } 
    mysqli_close($con);
} else {
    // If required parameter is missing
    $response["success"] = 0;
    $response["message"] = "Parameter(s) are missing. Please check the request";
 
    // Show JSON response
    echo json_encode($response);
}
?>