<?php
require_once '../../classes/respuestas.class.php';
require_once '../../classes/rutas.class.php';

$_respuestas = new respuestas;
$_rutas = new rutas;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //recibir datos
    $postBody = file_get_contents("php://input");
    //enviamos datos al manejador
    //print_r($postBody);
    $datosArray = $_rutas->postMetod($postBody);
    //devolvemos una respuesta
    header('Content-Type: application/json');
    if (isset($datosArray["result"]["error_id"])) {
        http_response_code(400);
    } else {
        http_response_code(200);
    }
    echo json_encode($datosArray);
} else {
    header('Content-Type: application/json');
    $datosArray = $_respuestas->error_405();
    echo json_encode($datosArray);
}