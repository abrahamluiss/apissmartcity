
<?php
require_once 'database/conexion.php';
require_once 'respuestas.class.php';

class insertarEmpresas extends conexion
{
    private $table_name = "Tbl_empresa_transp";

    private $ID_Empresa_Transp;
    private $EMT_Nombre;
    private $EMT_Ruc;
    private $EMT_Direccion;
    private $EMT_Telefono;
    private $EMT_Usuario;
    private $EMT_Contrasena;

    public function postMetod($json){
        $_respuestas = new respuestas;
        $datos = json_decode($json, true);
        if(!isset($datos['idEmpresa']) || !isset($datos['nombre']) || !isset($datos['ruc']) || !isset($datos['direccion']) || !isset($datos['telefono']) || !isset($datos['usuario']) || !isset($datos['pass'])){
            return $_respuestas->error_401();
        }else{
            $this->ID_Empresa_Transp = $datos['idEmpresa'];
            $this->EMT_Nombre = $datos['nombre'];
            $this->EMT_Ruc = $datos['ruc'];
            $this->EMT_Direccion = $datos['direccion'];
            $this->EMT_Telefono = $datos['telefono'];
            $this->EMT_Usuario = $datos['usuario'];
            $this->EMT_Contrasena = $datos['pass'];
            $resp = $this->insertaEmpresa();
            if ($resp) {
                
               $answer = array(
                    "status" => true,
                    "message" => "correctamente"
                );

                return $answer;
                

            } else {
                return $_respuestas->error_500();
            }
        }
    }
    private function insertaEmpresa(){
        $query = "INSERT INTO " . $this->table_name . "(ID_Empresa_Transp,EMT_Nombre,EMT_Ruc,EMT_Direccion,EMT_Telefono,EMT_Usuario,EMT_Contrasena) values ('" . $this->ID_Empresa_Transp ."','" . $this->EMT_Nombre ."','". $this->EMT_Ruc ."','" . $this->EMT_Direccion."','". $this->EMT_Telefono ."','". $this->EMT_Usuario ."','". $this->EMT_Contrasena ."')";

        $resp = parent::nonQuery($query);
        if($resp>0){
            return $resp;
        }else{
            return 0;
        }
        
        
    }
}