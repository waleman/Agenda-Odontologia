<?php
require_once 'conexion/conexion.php';

class usuarios extends conexion{


    public function verCorreo($UsuarioId){
        $query ="SELECT Usuario from usuarios where UsuarioId = '$UsuarioId'";
        $datos = parent::obtenerDatos($query);
        if($datos){
            return $datos[0]['Usuario'];
        }else{
            return false;
        }
    }
    
    public function listaUsuarios(){
        $query = "select u.UsuarioId,u.Usuario,u.Estado,r.Nombre as Rol 
        from usuarios as u , roles as r
        where r.RolId = u.RolId
        ";
        $datos = parent::obtenerDatos($query);
        if($datos){
            return $datos;
        }else{
            return false;
        }
    }

    public function guardar($usuario,$password,$rol){
        $usuario = parent::sanatizeItem($usuario,'string');
        $password = parent::Encriptar($password);
        $fecha = date("Y-m-d");
        $query="insert into usuarios (Usuario,Password,RolId,Estado,FC)values('$usuario','$password','$rol','Activo','$fecha')";
        $verificar = parent::nonQuery($query);
        if($verificar >= 1){
            return true;
        }else{
            return false;
        }
    }

    public function verificarNoRepetido($usuario){
        $query="select count(*) as cantidad from usuarios where Usuario = '$usuario'";
        $datos = parent::obtenerDatos($query);
        if($datos[0]['cantidad'] >= 1){
            return false;
        }else{
            return true;
        }
    }

    public function login($usuario,$password){
        $usuario = parent::sanatizeItem($usuario,'string');
        $password = parent::sanatizeItem($password,'sting');
        $password = parent::encriptar($password);
        $query= "select * from usuarios where Usuario = '$usuario' and Password = '$password'";
        $datos = parent::obtenerDatos($query);
        if(empty($datos)){
            return false;
        }else{
            return $datos;
        }
    } 

    public function salir(){
        session_start();
        session_destroy();
        session_unset();
    }

    public function verificarEmail($usuario){
        $usuario = parent::sanatizeItem($usuario,'string');
        $query= "select count(*) as cantidad from usuarios where Usuario = '$usuario'";
        $datos = parent::obtenerDatos($query);
            if($datos[0]['cantidad'] == 0){
                return false;
            }else{
                return true;
            }
    }


     public function cambiarContraseña($usuario,$password){
        $password = parent::sanatizeItem($password,'string');
        $password = parent::encriptar($password);
        $query ="UPDATE usuarios SET Password ='$password' WHERE UsuarioId='$usuario'";
        $verificar = parent::nonQuery($query);
        if($verificar >= 1){
            return true;
        }else{
            return false;
        }
     }

     public function verificarContraseña($usuario,$password){
         $password = parent::encriptar($password);
         $query = "SELECT Password from usuarios where UsuarioId = '$usuario'";
         $datos = parent::obtenerDatos($query);
         $Actual = $datos[0]['Password'];
         if ($Actual == $password){
            return true;
         }else{
             return false;
         }
     }


     public function listaRoles(){
         $query = "SELECT * from roles";
         $respuesta = parent::obtenerDatos($query);
         if($respuesta){
             return $respuesta;
         }else{
             return false;
         }
     }

     public function buscarUsuario($id){
        $query = "select Usuario,RolId,Estado from usuarios where UsuarioId='$id'";
        $datos = parent::obtenerDatos($query);
        if($datos){
            return $datos;
        }else{
            return false;
        }
    }




}

?>