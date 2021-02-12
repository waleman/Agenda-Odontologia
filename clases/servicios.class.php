<?php
require_once 'conexion/conexion.php';

class servicios extends conexion{

    public function guardar($nombre,$categoria,$precio,$iva){
        $query = "INSERT INTO servicios (Nombre,CategoriaId,Precio,IVA,Estado)values('$nombre','$categoria','$precio','$iva','Activo')";
        $resp = parent::nonQuery($query);
        if($resp >= 1){
            return true;
        }else{
            return false;
        }
    }

    public function editar($nombre,$estado,$servicioid,$precio,$iva){
        $query = "UPDATE servicios SET Nombre='$nombre',Estado = '$estado',Precio= '$precio',IVA ='$iva' WHERE ServicioId='$servicioid'";
        $resp = parent::nonQuery($query);
        if($resp >= 1){
            return true;
        }else{
            return false;
        }
    }

    public function listaservicios($categoria = 0){
        $query="SELECT ServicioId,Nombre FROM servicios WHERE Estado = 'Activo' AND CategoriaId ='$categoria'";
        $respuesta = parent::obtenerDatos($query);
        if($respuesta){
            return $respuesta;
        }else{
            return array();
        }
    }

    public function listaServiciosCompleta(){
        $query="SELECT ServicioId,Nombre,Precio,IVA,CategoriaId,Estado FROM servicios ";
        $respuesta = parent::obtenerDatos($query);
        if($respuesta){
            return $respuesta;
        }else{
            return false;
        }
    }

    public function obtenerServicio($id){
        $query = "SELECT * FROM servicios WHERE ServicioId ='$id'";
        $respuesta = parent::obtenerDatos($query);
        if($respuesta){
            return $respuesta;
        }else{
            return false;
        }
    }


    public function obtenerCategorias(){
        $query="SELECT * FROM categorias order by Nombre";
        $resp = parent::obtenerDatos($query);
        if($resp){
            return $resp;
        }else{
            return array();
        }
    }

}
?>