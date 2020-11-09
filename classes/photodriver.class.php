<?php
require_once 'database/conexion.php';
require_once 'respuestas.class.php';

class photodriver extends conexion
{

    private $table_name = "tbl_vehiculo";
    private $id_driver = "";
    private $placa = "";
    private $placa_name = "";


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
                $respIdDriver = $arrayToken[0]["ID_Conductor"]; //$datos[0]["ID_USUARIO"]
                if (!isset($datos['placa_photo'])) {
                    return $_respuestas->error_400();
                } else {
                  //  $placaImage = $this->placa=$datos['placa_photo'];
                  $this->placa=$datos['placa_photo'];
                  $this->id_driver = $respIdDriver;

                    $resp = $this->actualizarPlaca();

                    if ($resp) {
                        $user_arr = array(

                            "status" => true,
                        );
                        return $user_arr;
                    }else{
                        return $_respuestas->error_500();

                    }
                }
            } else {
                return $_respuestas->error_401("El Token que envio es invalido o ha caducado");
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



    private function actualizarPlaca()
    {
        $query = "UPDATE " . $this->table_name . " SET VEH_Placa='" . $this->placa . "' WHERE ID_Conductor= '" . $this->id_driver . "'";
        $resp = parent::nonQuery($query);

        if ($resp >= 1) {
            return $resp;
        } else {
            return 0;
        }
    }
}
