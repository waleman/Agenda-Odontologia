<?php
require_once 'conexion/conexion.php';

class consultas extends conexion{

    // public function verificarExsiste($citaId){
    //     $query = "SELECT ConsultaId FROM consultas WHERE CitaId = '$citaId'";
    //     $datos = parent::obtenerDatos($query);
    //     if($datos){
    //         return $datos;
    //     }else{
    //         return false;
    //     }
    // }

    // public function CrearConsulta($citaId){
    //     $query = "INSERT INTO consultas (CitaId)values('$citaId')";
    //     $resp = parent::nonQueryId($query);
    //     if($resp >= 1){
    //         return $resp;
    //     }else{
    //         return 0;
    //     }
    // }

    // public function ModificarAntecedentes($antecedentes,$pacienteid){
    //     $query = "UPDATE pacientes SET Antecedentes ='$antecedentes' WHERE PacienteId='$pacienteid'";
    //     $resp = parent::nonQuery($query);
    //     if($resp >= 1){
    //         return $resp;
    //     }else{
    //         return 0;
    //     }
    // }

    // public function modificarConsulta($consultaid,$observaciones,$tratamientos,$servicioid){
    //     $query ="UPDATE consultas SET ServicioId ='$servicioid',Observaciones = '$observaciones', Tratamiento = '$tratamientos' WHERE ConsultaId='$consultaid'";
    //     $resp = parent::nonQuery($query);
    //     if($resp >= 1){
    //         return $resp;
    //     }else{
    //         return 0;
    //     }
    // }

    // public function obtenerConsulta($consultaid){
    //     $query ="SELECT * FROM consultas where ConsultaId ='$consultaid'";
    //     $datos = parent::obtenerDatos($query);
    //     if($datos){
    //         return $datos;
    //     }else{
    //         return false;
    //     }
    // }

    
    // public function obtenerConsultasCitas($consultaid,$pacienteid){
    //     $query ="SELECT ci.Fecha,ci.Inicio,ci.Motivo,c.Tratamiento,c.Observaciones,s.Nombre AS Servicio FROM consultas AS c, citas AS ci,servicios AS s
    //     WHERE c.CitaId = ci.CitaId
    //     AND s.ServicioId = c.ServicioId
    //     AND ci.PacienteId = '$pacienteid'
    //     AND c.ConsultaId <> '$consultaid'
    //     ORDER BY ci.Fecha";
    //     $respuesta = parent::obtenerDatos($query);
    //     if($respuesta){
    //         return $respuesta;
    //     }else{
    //         return false;
    //     }

    // }

    



 
}


?>