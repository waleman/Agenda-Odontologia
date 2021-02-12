<?php
require_once 'conexion/conexion.php';

class clinica extends conexion{

    public function datosClinica(){
        $query = "SELECT * FROM clinicas";
        $respuesta = parent::obtenerDatos($query);
        if(!empty($respuesta)){
            return $respuesta[0];
        }else{
            return array();
        }
    }

    public function editarClinica($nombre,$direccion,$correo,$telefono,$web,$cif,$crc,$titular,$iban){
        $query = "UPDATE clinicas SET 
        Nombre = '$nombre',
        Direccion = '$direccion',
        Correo = '$correo',
        Telefono = '$telefono',
        Web = '$web',
        CIF = '$cif',
        CRC = '$crc',
        Titular = '$titular',
        IBAN = '$iban'
        WHERE ClinicaId = '1'";
        $respuesta = parent::nonQuery($query);
        if($respuesta){
            return true;
        }else {
            return false;
        }
    }

    public function editarHorarios($inicio,$fin,$duracion,$lunes,$martes,$miercoles,$jueves,$viernes,$sabado,$domingo){
        $query = "UPDATE clinicas SET 
        HoraInicio = '$inicio',
        HoraFin = '$fin',
        Duracion = '$duracion',
        Domingo = '$domingo',
        Lunes = '$lunes',
        Martes = '$martes',
        Miercoles = '$miercoles',
        Jueves = '$jueves',
        viernes = '$viernes',
        Sabado = '$sabado'
        WHERE ClinicaId = '1'";
        $respuesta = parent::nonQuery($query);
        if($respuesta > 0){
            return true;
        }else {
            return false;
        }
    }


    public function datosCalendarioClinica(){
        $query = "SELECT HoraInicio,HoraFin,Duracion,Lunes,Martes,Miercoles,Jueves,Viernes,Sabado,Domingo from clinicas WHERE ClinicaId= '1'";
        $respuesta = parent::obtenerDatos($query);
        if(!empty($respuesta)){
            return $respuesta[0];
        }else{
            return array();
        }
    }

    public function nombreClinica(){
        $query = "SELECT Nombre from clinicas WHERE ClinicaId= '1'";
        $respuesta = parent::obtenerDatos($query);
        if(!empty($respuesta)){
            return $respuesta[0]['Nombre'];
        }else{
            return array();
        }
    }

}


?>