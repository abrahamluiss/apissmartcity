<?php
require_once '../../classes/respuestas.class.php';
require_once '../../classes/profile.class.php';

$_respuestas = new respuestas;
$_profile = new profile;

if($_SERVER['REQUEST_METHOD'] == "GET"){
    $headers = getallheaders();
    if(isset($headers['token'])){
       $send = [
           "token" => $headers['token'],
       ];
        $postBody = json_encode($send);
    }
        //enviamos datos al manejador
        $datosArray = $_profile->get($postBody);
        //delvovemos una respuesta 
           header('Content-Type: application/json');
           if(isset($datosArray["result"]["error_id"])){

                $responseCode = $datosArray["result"]["error_id"];
                http_response_code($responseCode);
           }else{
                http_response_code(200);
           }
           echo json_encode($datosArray); 

} else{
    header('Content-Type: application/json');
    $datosArray = $_respuestas->error_405();
    echo json_encode($datosArray);
}


