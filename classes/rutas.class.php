<?php
require_once 'database/conexion.php';
require_once 'respuestas.class.php';
class rutas extends conexion
{
    private $table_name = "tbl_ruta";
    private $ID_Ruta;
    public $querys;
    public function postMetod($json)
    {
        $_respuestas = new respuestas;
        $datos = json_decode($json, true);
        if (!isset($datos['idEmpresa'])) {
            return $_respuestas->error_400();
        } else {
            $idEmp = $datos['idEmpresa'];
            $datosRuta = $this->obtenerDatosRuta($idEmp);
            if($datosRuta){
                $ID_Ruta = $datosRuta[0]["ID_Ruta"];
                $resp = $this->tramos($ID_Ruta);
                if($resp){
                    $respuesta[] = array(
                        "rutas" => $resp
                    );
                    return $respuesta;
                }else{
                    return $_respuestas->error_500();
                }
            }else{
                return $_respuestas->error_500();

            }
        }
    }
    private function obtenerDatosRuta($id)
    {
        $query = "SELECT ID_Ruta, RUT_Nombre FROM tbl_ruta WHERE ID_Empresa_Transp = '$id'";
        $datos = parent::obtenerDatos($query);

        //if (isset($datos[0]["ID_Ruta"])) {
        if ($datos) {
            return $datos;
        } else {
            return 0;
        }
    }
    private function tramos($idRuta){
        
        $querys = "SELECT ID_Tramos, RT_Longitud_inicio, RT_Longitud_final, RT_Latitud_inicio, RT_Latitud_final FROM Tbl_ruta_tramos WHERE ID_Ruta = '$idRuta'";
        $datos = parent::obtenerDatos($querys);
        if ($datos) {
            return $datos;
        } else {
            return 0;
        }
    }
}
