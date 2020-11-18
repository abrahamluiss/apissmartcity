<?php
require_once 'database/conexion.php';
require_once 'respuestas.class.php';
class allUsers extends conexion{
    private $conn;
    private $table_name = "Tbl_Usuario";
  
    // object properties
    public $ID_Usuario;
    public $US_Nombres;
    public $US_Apellidos;
    public $US_Direccion;
    public $US_Fecha_Nacimiento;
    public $US_Nacionalidad;
    public $US_Telefono;
    public $US_Email;
    public $US_Contrasena;
    public $US_Tipo;

    public function get($json)
    {
        $_respuestas = new respuestas;
        //$datos = json_decode($json, true);
                 
                $resp = $this->mostrarUsuarios();
                
                if ($resp) {
                    /*
                    $respuesta = $_respuestas->response;
                    $respuesta["result"] = array(
                        "US_usuarioId" => $this->ID_Usuario
                    );
                    */
                    //echo 'hola';
                    
                    $user_arr = array(
                        "status" => true,
                        "nombres" => $resp[0]['US_Nombres'],
                        "apellido" => $resp[0]['US_Apellidos'],
                        "correo" => $resp[0]['US_Email'],
                        "telefono" => $resp[0]['US_Telefono'],
                        "direccion" => $resp[0]['US_Direccion'],
                        "nacionalidad" => $resp[0]['US_Nacionalidad'],
                        //"id_user" => $datos[0]['ID_Usuario'],
                        //"token" => $resp
                    );
                    return $resp;
                }else{
                    return $_respuestas->error_400();
                }
           
        

    }

    public function mostrarUsuarios(){
        $query = "SELECT US_Nombres,US_Apellidos, US_Direccion, US_Fecha_Nacimiento,US_Nacionalidad,US_Telefono,US_Email FROM " . $this->table_name . "";

        $datos = parent::obtenerDatos($query);
        return($datos);
    }
}