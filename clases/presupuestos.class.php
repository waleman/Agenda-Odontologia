<?php 
require_once 'conexion/conexion.php';

class presupuestos extends conexion {


    public function obtenerPresupuestosPaciente($pacienteId){
        $query = "SELECT * FROM presupuestos WHERE PacienteId = '$pacienteId' order by PresupuestoId Desc";
        $resp =parent::obtenerDatos($query);
        if($resp){
            return $resp;
        }else{
            return array();
        }
    }

    public function crearPresupuesto($pacienteId,$usuarioId,$nombre,$uc){
        $codigo = $this->obtenerCantidadPresupuestosPaciente($pacienteId);
        $codigo = "000" . $codigo + 1;
        $fecha = date("Y-m-d");
        $query = "INSERT INTO presupuestos(Nombre,PacienteId,UsuarioId,Fecha,Estado,Codigo,UC)VALUES('$nombre','$pacienteId','$usuarioId','$fecha','1','$codigo','$uc')";
        $resp = parent::nonQueryId($query);
        if($resp > 0){
            return $resp;
        }else {
            return 0;
        }

    }

    public function obtenerCantidadPresupuestosPaciente($pacienteId){
        $query ="SELECT count(*) as Cantidad FROM presupuestos WHERE PacienteId = '$pacienteId'";
        $resp = parent::obtenerDatos($query);
        if($resp){
            return $resp[0]['Cantidad'];
        }else{
            return 0;
        }
    }



    public function gudardarDetallePresupuesto($presupuestoid,$servicioid,$servicionombre,$categoriaid,$categorianombre,$diente,$caraid,$caranombre,$observacion,$estado,$precio,$iva){
        $query= "
        INSERT INTO presupuestos_detalle
            (PresupuestoId,
            ServicioId,
            CategoriaId,
            Diente,
            CaraId,
            Cara,
            Categoria,
            Servicio,
            Observacion,
            Estado,
            IVA,
            Precio)
        VALUES
            ('$presupuestoid',
            '$servicioid',
            '$categoriaid',
            '$diente',
            '$caraid',
            '$caranombre',
            '$categorianombre',
            '$servicionombre',
            '$observacion',
            '$estado',
            '$iva',
            '$precio'
            );
        ";
         $resp = parent::nonQuery($query);
         if($resp > 0){
             return true;
         }else{
             return false;
         }
    }

    public function obtenerDetallePresupuesto($presupuestoid){
        $query= "SELECT * FROM presupuestos_detalle WHERE PresupuestoId = '$presupuestoid'";
        $resp = parent::obtenerDatos($query);
        if($resp){
            return $resp;
        }else{
            return array();
        }
    }

    public function obtenerDetallePorId($presupuestodetalleId){
        $query="SELECT Observacion,Servicio,Diente,Cara,Categoria FROM presupuestos_detalle WHERE PresupuestoDetalleId = '$presupuestodetalleId' ";
        $resp = parent::obtenerDatos($query);
        if($resp){
            return $resp;
        }else{
            return array();
        }
    }

    public function editarComentario($presupuestodetalleId,$comentario){
        $query = "UPDATE presupuestos_detalle SET Observacion ='$comentario' WHERE PresupuestoDetalleId = '$presupuestodetalleId'";
        $resp = parent::nonQuery($query);
        if($resp > 0){
            return true;
        }else{
            return false;
        }
    }
    public function editarPrecio($presupuestodetalleId,$precio){
        $query = "UPDATE presupuestos_detalle SET Precio ='$precio' WHERE PresupuestoDetalleId = '$presupuestodetalleId'";
        $resp = parent::nonQuery($query);
        if($resp > 0){
            return true;
        }else{
            return false;
        }
    }


    public function eliminarDetalle($presupuestodetalleId){
        $query = "DELETE FROM presupuestos_detalle WHERE PresupuestoDetalleId = '$presupuestodetalleId'";
        $resp = parent::nonQuery($query);
        if($resp > 0){
            return true;
        }else{
            return false;
        }
    }


    public function impirmirTabla($presupuestoid){
        $sumaTotal = "0.00";
        $ListaServicios = $this->obtenerDetallePresupuesto($presupuestoid);

        $html = "
        <table id='contenido' class='table table-outline table-responsive  table-bordered table-striped table-hover' >
            <thead  >
                <tr class='bg-primary'>
                    <th scope='col'>Acciones</th>
                    <th scope='col'>Tratamiento</th>
                    <th scope='col'>Pieza</th>
                    <th scope='col'>Cara</th>
                    <th scope='col'>Observacion</th>
                    <th scope='col'>Precio</th>
                    <th scope='col'>IVA</th>
                    <th scope='col'>Total</th>
                </tr>
            </thead>
            <tbody>";            
            foreach ($ListaServicios as $key => $value) {
                 $detalleid = $value['PresupuestoDetalleId'];
                 $ServicioNombre = $value['Servicio'];
                 $Precio = $value['Precio'];
                 $IVA = $value['IVA'];
                 $DienteId = $value['Diente'];
                 $Cara = $value['Cara'];
                 $total = $IVA + $Precio ;
                 $Observacion = $value['Observacion'];
                 $sumaTotal = $total + $sumaTotal;
                 $html .= "
                    <tr>
                         <td class='col-md-2'> 
                            <a data-codigo='$detalleid' class='btn btn-success btn-raised btn-xs'><i class='zmdi zmdi-edit'></i><div class='ripple-container'></div></a>
                            <a data-borrar='$detalleid' class='btn btn-danger btn-raised btn-xs'><i class='zmdi zmdi-delete'></i><div class='ripple-container'></div></a>
                            <a data-estado='$detalleid' class='btn btn-primary btn-raised btn-xs'><i class='zmdi zmdi-money-box'></i><div class='ripple-container'></div></a>
                         </td>
                         <td class='col-md-2'> $ServicioNombre</td>
                         <td class='col-md-1'> $DienteId</td>
                         <td class='col-md-1'> $Cara</td>
                         <td class='col-md-3'> $Observacion</td>
                         <td class='col-md-1'> 
                            <input type='text' class='textboxprecio' id='$detalleid' name='$detalleid' size='9' value='$Precio'> €
                         </td>
                         <td class='col-md-1' style='text-align:right'> $IVA €</td>
                         <td class='col-md-2' style='text-align:right'> $total €</td>
                    </tr>
                 ";
            }
                
               $html .= "      </tbody>
                </table> 
                <div style='text-align:right'> <h3><b>Total:</b> $sumaTotal € </h3>   </div>
                ";

                return $html;
    }


    public function eliminarPresupuesto($presupuestoid){
        $query = "DELETE FROM presupuestos WHERE PresupuestoId='$presupuestoid'";
        $resp = parent::nonQuery($query);
        $query ="DELETE FROM presupuestos_detalle WHERE PresupuestoId='$presupuestoid'";
        $resp2 = parent::nonQuery($query);
        if($resp > 0 ){
            return true;
        }else{
            return false;
        }
    }



}


?>