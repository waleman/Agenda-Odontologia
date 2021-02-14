<?php
require_once 'conexion/conexion.php';

class pacientes extends conexion{

    public function guardarPaciente($nombre,$telefono,$correo,$genero){
        $fecha = date('Y-m-d');
        $query = "INSERT INTO pacientes(Nombre,Telefono,Correo,Genero,FC)values('$nombre','$telefono','$correo','$genero','$fecha')";
        $respuesta = parent::nonQueryId($query);
        if($respuesta >= 1){
            return $respuesta;
        }else{
            return 0;
        }
    } 

    public function buscarPacientes($dato){
        $query ="SELECT * FROM pacientes where Nombre like '%$dato%' or Telefono like '%$dato%' or Correo like '%$dato%' LIMIT 50";
        $respuesta = parent::obtenerDatos($query);
        if($respuesta){
            return $respuesta;
        }else{
            return false;
        }
    }

    public function listaPacientes(){
        $query="SELECT * FROM pacientes ORDER BY PacienteId DESC LIMIT 50";
        $respuesta = parent::obtenerDatos($query);
        if($respuesta){
            return $respuesta;
        }else{
            return false;
        }
    }

    public function lista10Pacientes(){
        $query="SELECT * FROM pacientes ORDER BY PacienteId DESC LIMIT 8";
        $respuesta = parent::obtenerDatos($query);
        if($respuesta){
            return $respuesta;
        }else{
            return false;
        }
    }

    public function editarPaciente($codigo,$nombre,$nif,$direccion,$pais,$provincia,$poblacion,$genero,$correo,$telefono,$fechaNac,$alergias,$observaciones,$pacienteId){
        $query= "UPDATE pacientes SET 
        Codigo = '$codigo',
        Nombre='$nombre',
        NIF='$nif',
        Direccion='$direccion',
        PaisId='$pais',
        ProvinciaId ='$provincia',
        LocalidadId = '$poblacion',
        Genero = '$genero',
        Correo = '$correo',
        Telefono = '$telefono',
        FechaNacimiento = '$fechaNac',
        Alergias = '$alergias',
        Antecedentes = '$observaciones'
        WHERE PacienteId='$pacienteId'";
        //print_r($query);
        $respuesta = parent::nonQuery($query);
        if($respuesta  >= 1){
            return true;
        }else{
            return false;
        }
    }

    public function buscarPacientePorId($pacienteId){
        $query = "SELECT * FROM pacientes WHERE PacienteId='$pacienteId'";
        $respuesta = parent::obtenerDatos($query);
        if($respuesta){
            return $respuesta;
        }else{
            return array();
        }
    }

    public function obtenerCitasPaciente($pacienteId){
        $query ="select CitaId,Fecha,Inicio,Motivo from citas where PacienteId = '$pacienteId' ORDER BY Fecha DESC";
        $respuesta = parent::obtenerDatos($query);
        if($respuesta){
            return $respuesta;
        }else{
            return array();
        }
    }

    public function obtenerConsultasCitas($citaid){
        $query =" select Observaciones,Tratamiento,s.Nombre as Servicio from consultas as c , servicios as s
        where c.ServicioId = s.ServicioId
        and CitaId = '$citaid'";
        $respuesta = parent::obtenerDatos($query);
        if($respuesta){
            return $respuesta[0];
        }else{
            return false;
        }

    }

    function edad($fecha_nacimiento) { 
        $tiempo = strtotime($fecha_nacimiento); 
        $ahora = time(); 
        $edad = ($ahora-$tiempo)/(60*60*24*365.25); 
        $edad = floor($edad); 
        return $edad; 
    } 

    public function obtenerPaises(){
        $query="SELECT * from paises";
        $resp = parent::obtenerDatos($query);
        if($resp){
            return $resp;
        }else {
            return array();
        }
    } 

    public function obtenerProvincias($paisId){
        $query="SELECT ProvinciaId,Nombre from provincias WHERE Estado = 'Activo' AND PaisId ='$paisId'";
        $resp = parent::obtenerDatos($query);
        if($resp){
            return $resp;
        }else {
            return array();
        }
    }

    public function obtenerPoblaciones($provinaciaId){
        $query="SELECT LocalidadId,Nombre from localidades WHERE Estado = 'Activo' AND ProvinciaId ='$provinaciaId'";
        $resp = parent::obtenerDatos($query);
        if($resp){
            return $resp;
        }else {
            return array();
        }
    }

    public function obtenerNombre($pacienteId){
        $query = "SELECT Nombre from pacientes WHERE PacienteId='$pacienteId'";
        $resp = parent::obtenerDatos($query);
        if($resp){
            return $resp[0]['Nombre'];
        }else{
            return "";
        }    
    }


}


?>