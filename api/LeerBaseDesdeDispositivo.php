<?php
 
/****************************************************/
/******Partiendo del trabajo de Vivek Gupta ************/
/****************************/

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
//Creating Array for JSON response
$response = array();
 
// Include data base connect class
$filepath = realpath (dirname(__FILE__));
require_once($filepath."/dbconnect.php");
 // Connecting to database
$db = new DB_CONNECT();
 
$con=mysqli_connect(DB_SERVER,DB_USER,DB_PASSWORD,DB_DATABASE);
if (mysqli_connect_errno()) {
    echo "Fallo la conexión a MYSQL Maria: " . mysqli_connect_error(); 
}

// Check if we got the field from the user
if (isset($_GET["idAlarma"])) {
    
    $idAlarma = $_GET['idAlarma'];
 
     // Consulta en SQL
    $result = mysqli_query($con,"SELECT *FROM alarma WHERE idAlarma = '$idAlarma'");
    
    //Si la respuesta no es vacio
    if (!empty($result)) {
        // Consulta hecha con resultados con una fila o mas
        if (mysqli_num_rows($result) > 0) {
            
            // Storing the returned array in response
            $result = mysqli_fetch_array($result);
            
            // Matriz temporal
            $alarma = array();
            $alarma["idAlarma"] = $result["idAlarma"];
            $alarma["estado"] = $result["estado"];

            $response["success"] = 1;
            $response["alarma"] = array();
            
            // Agrega los items 
            array_push($response["alarma"], $alarma);
 
            // Show JSON response
            echo json_encode($response);
        } else {
            // If no data is found
            $response["success"] = 0;
            $response["message"] = "Ningun dato encontrado";
 
            // Show JSON response
            echo json_encode($response);
        }
    } else {
        // Si la respuesta es vacio
        $response["success"] = 0;
        $response["message"] = "Ningun dato encontrado";
 
        // mostrar respuesta en codificación JSON 
        echo json_encode($response);
    }

} else {
    // Faltan parametros
    $response["success"] = 0;
    $response["message"] = "Faltan Parametros, por favor revisar la consulta.";
 
    // echoing JSON response
    echo json_encode($response);
}

mysqli_close($con);

?>