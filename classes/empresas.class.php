<?php
require_once 'database/conexion.php';
require_once 'respuestas.class.php';

class empresas extends conexion
{
    private $table_name = "Tbl_empresa_transp";
    public function getMetod($json)
    {
        $_respuestas = new respuestas;
        $resp = $this->mostrarEmpresasTransporte();

        if ($resp) {
            $respuesta[] = array(
                "empresa" => $resp
            );
            return $respuesta;
        } else {
            return $_respuestas->error_400();
        }
    }
    private function mostrarEmpresasTransporte()
    {
        $query = "SELECT EMT_Nombre, EMT_Ruc, EMT_Direccion, EMT_Telefono, EMT_Usuario FROM " . $this->table_name . "";
        $datos = parent::obtenerDatos($query);
        return ($datos);
    }
}
