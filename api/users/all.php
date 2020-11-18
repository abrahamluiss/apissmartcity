<?php
require_once '../../classes/respuestas.class.php';
require_once '../../classes/allUsers.class.php';

$_respuestas = new respuestas;
$_allUsers = new allUsers;

if($_SERVER['REQUEST_METHOD'] == "GET"){
    $data = json_decode(file_get_contents("php://input"));

        //enviamos datos al manejador
        $datosArray = $_allUsers->get($data);
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


