<?php
require_once 'database/conexion.php';
require_once 'respuestas.class.php';

class setlocation extends conexion
{
    private $table_name = "Tbl_Conductor";
    // object properties
    public $ID_Conductor;
    public $CON_Nombre;
    public $CON_Apellidos;
    public $CON_Telefono;
    public $CON_Direccion;
    public $CON_Licencia;
    public $ID_Empresa_Transp;
    public $CON_Latitud;
    public $CON_Longitud;
    public $CON_Status;
    public $CON_FCM;
    public $CON_Fotografia_Licencia;
    public $CON_Contrasena;
    public $CON_Email;
    public $Nombre_Conductor;
    public $Nombre_Empresa;

    public function postMetod($json)
    {
        $_respuestas = new respuestas;
        $datos = json_decode($json, true);
        if (!isset($datos['token'])) {
            return $_respuestas->error_401();
        } else {
            $this->token = $datos['token'];
            $arrayToken = $this->buscarToken();

            if ($arrayToken) {
                if (!isset($datos['latitud']) || !isset($datos['longitud'])) {
                    return $_respuestas->error_400();
                } else {

                    $this->ID_Conductor = $arrayToken[0]["ID_Conductor"];
                    $this->CON_Latitud = $datos['latitud'];
                    $this->CON_Longitud = $datos['longitud'];


                    $resp = $this->setLatLong();
                    
                    if ($resp) {
                        $answer = array(
                            "status" => true,
                            "message" => "Lat y long enviados correctamente"
                        );
                        return $answer;
                    } else {
                        return $_respuestas->error_500();
                    }
                    
                }
            } else {
                return $_respuestas->error_500();
            }
        }
    }
    private function buscarToken()
    {
        $query = "SELECT  TokenId,ID_Conductor,Estado from driver_token WHERE Token = '" . $this->token . "' AND Estado = 'Activo'";
        $resp = parent::obtenerDatos($query);
        if ($resp) {
            return $resp;
        } else {
            return 0;
        }
    }
    private function setLatLong()
    {
        $query = "UPDATE " . $this->table_name . " SET CON_Latitud ='" . $this->CON_Latitud . "',CON_Longitud = '" . $this->CON_Longitud . "' WHERE ID_Conductor = '" . $this->ID_Conductor . "'";
        $resp = parent::nonQuery($query);
        if ($resp) {
            return $resp;
        } else {
            return 0;
        }
    }
}
