<?php
require_once 'conexion/conexion.php';

class solicitud extends conexion {

    function crearsolicitud($pacineteId){
        $fecha = date("Y-m-d");
        $query = "INSERT INTO solicitudes (PacienteId,Fecha)VALUES('$pacineteId','$fecha')";
        $verificar = parent::nonQueryId($query);
        if($verificar > 0){
            return $verificar;
        }else{
            return 0;
        }
    }


    function verEstadoSolicitud($solicitudId){
        $query = "SELECT Estado FROM solicitudes WHERE SolicitudId='$solicitudId'";
        $verificar = parent::obtenerDatos($query);
        if(isset($verificar[0]["Estado"])){
            return $verificar[0]["Estado"];
        }else{
            return 0;
        }

    }


    function obtenerTexto(){
        $query ="SELECT * from consentimiento WHERE Estado='Activo'";
        $datos = parent::obtenerDatos($query);
        if($datos){
            return $datos[0];
        }else{
            return array();
        }
    }

    function obtenerPacienteIdSolicitud($solicitudId){
        $query="SELECT PacienteId from solicitudes WHERE SolicitudId='$solicitudId'";
        $datos = parent::obtenerDatos($query);
        if($datos){
            return $datos[0]['PacienteId'];
        }else{
            return 0;
        }
    }

    function buscarPacientePorId($pacienteId){
        $query = "SELECT Nombre,Telefono,Correo,NIF FROM pacientes WHERE PacienteId='$pacienteId'";
        $respuesta = parent::obtenerDatos($query);
        if($respuesta){
            return $respuesta[0];
        }else{
            return array();
        }
    }

    function obtenerNombreClinica(){
        $query = "SELECT Nombre from clinicas WHERE ClinicaId='1'";
        $datos =  parent::obtenerDatos($query);
        if($datos){
            return $datos[0]["Nombre"];
        }else{
            return 0;
        }
    }


    function editarPaciente($pacienteId,$email,$telefono,$sms,$tratamiento){
        $query ="UPDATE pacientes SET ConsentimientoTratamiento='$tratamiento',ConsentimientoSMS='$sms',ConsentimientoTelefono='$telefono',ConsentimientoEmail='$email',ConsentimientoEstado='1'
        WHERE PacienteId='$pacienteId'";
        $resp = parent::nonQuery($query);
        if($resp > 0){
            return true;
        }else{
            return false;
        }
    }

    function uploadImgBase64 ($base64, $name){
        $datosBase64 = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64));
        $path = "public/firmas/$name";
        if(!file_put_contents($path, $datosBase64)){
          return false;
        }else{
          return true;
        }
    }


    function actualizarSolicitud($solicitudId){
        $query="UPDATE solicitudes SET Estado = 'Inactivo' WHERE SolicitudId ='$solicitudId'";
        $resp = parent::nonQuery($query);
        if($resp > 0){
            return true;
        }else{
            return false;
        }
    }
 

    function buscarSolicitudActiva(){
        $query = "select SolicitudId from solicitudes where Estado = 'Activo' order by Fecha desc";
        $resp = parent::obtenerDatos($query);
        if($resp){
            return $resp[0]['SolicitudId'];
        }else{
            return 0;
        }
    }

}

?>