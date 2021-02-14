<?php 
require_once 'conexion/conexion.php';

class citas extends conexion {
    
    public function guardarCita($pacienteid,$fecha,$horainicio,$horafin,$motivo){
        $fc = date('Y-m-d');
        $query ="INSERT INTO citas (PacienteId,Fecha,Inicio,Fin,Estado,FC,Motivo)values('$pacienteid','$fecha','$horainicio','$horafin','Activo','$fc','$motivo')";
        $respuesta = parent::nonQuery($query);
        if($respuesta  >= 1){
            return true;
        }else{
            return false;
        }
    }
    
    public function obtenerCita($id){
        $query = "select c.CitaId,c.PacienteId,p.Nombre,p.Correo,p.Telefono,c.Fecha,c.Inicio,c.Fin,c.Estado,c.Motivo
        from citas as c,pacientes as p
        where c.CitaId='$id'
        and c.PacienteId = p.PacienteId";
        $datos = parent::obtenerDatos($query);
        if($datos){
            return $datos[0];
        }else{
            return false;
        }
    }

    public function listaCitas(){
        $query="SELECT c.CitaId,c.Fecha,c.Inicio,c.Fin,p.Nombre,c.Estado
        from citas as c,pacientes as p 
                where c.PacienteId = p.PacienteId
                and (c.Estado = 'Activo' OR c.Estado = 'Confirmada')
        ";
    
        $datos = parent::obtenerDatos($query);
        if($datos){
            return $datos;
        }else{
            return array();
        }
    } 

    public function listaCitasPaciente($pacienteId){
        $query="SELECT c.CitaId,c.Fecha,c.Inicio,c.Fin,p.Nombre,c.Estado
        from citas as c,pacientes as p 
                where c.PacienteId = p.PacienteId
                and (c.Estado = 'Activo' OR c.Estado = 'Confirmada')
                and c.PacienteId = '$pacienteId'
        ";
        // print_r($query);
        $datos = parent::obtenerDatos($query);
        if($datos){
            return $datos;
        }else{
            return false;
        }
    }

    public function eliminar($id){
        $query="DELETE FROM citas where CitaId = '$id'";
        $respuesta = parent::nonQuery($query);
        if($respuesta  >= 1){
            return true;
        }else{
            return false;
        }
    }

    public function editarCita($fecha,$inicio,$fin,$motivo,$citaid){
        $query ="UPDATE citas SET Fecha='$fecha',Inicio='$inicio',Fin='$fin',Motivo ='$motivo' WHERE CitaId = '$citaid'";
        $respuesta = parent::nonQuery($query);
        if($respuesta  >= 1){
            return true;
        }else{
            return false;
        }
    }

    public function actualizarConfirmada($citaId){
        $query = "UPDATE citas SET Estado = 'Confirmada' WHERE CitaId = '$citaId'";
        $respuesta = parent::nonQuery($query);
        if($respuesta  >= 1){
            return true;
        }else{
            return false;
        }
    }

    public function datosCita($citaid){
        $query="SELECT PacienteId,Fecha,Inicio,Fin,Motivo FROM citas WHERE CitaId='$citaid'";
        $datos = parent::obtenerDatos($query);
        if($datos){
            return $datos[0];
        }else{
            return false;
        } 
    }

    public function modificarDragAndDrop($id,$fecha,$inicio,$fin){
        $query ="UPDATE citas SET Fecha ='$fecha', Inicio = '$inicio', Fin = '$fin' WHERE
        CitaId = '$id'
        ";
        $verificar = parent::nonQuery($query);
        if($verificar >= 1){
            return true;
        }else{
            return false;
        }
    }


    
    public function obtenerPacienteIdDesdeCita($citaId){
        $query ="SELECT PacienteId from citas WHERE CitaId='$citaId'";
        $resp = parent::obtenerDatos($query);
        if($resp){
            return $resp[0]['PacienteId'];
        }else{
            return 0;
        }
    }
}

?>