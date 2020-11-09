<?php
require_once '../../classes/photodriver.class.php';
require_once '../../classes/respuestas.class.php';
$_respuestas = new respuestas;
$_photodriver = new photodriver;

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    //recibimos los datos enviados
    $postBody = file_get_contents("php://input");
    //enviamos los datos al manejador
    $datosArray = $_photodriver->postMetod($postBody);
    //delvovemos una respuesta 
     header('Content-Type: application/json');
     if(isset($datosArray["result"]["error_id"])){
         $responseCode = $datosArray["result"]["error_id"];
         http_response_code($responseCode);
     }else{
         http_response_code(200);
     }
     echo json_encode($datosArray);
    
}
