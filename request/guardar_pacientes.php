<?php
require_once '../clases/pacientes.class.php';
$_pacientes = new pacientes;


    $nombre = $_POST['txtnombre'];
    $telefono = $_POST['txttelefono'] ;
    $correo = $_POST['txtemail'];
    $genero = $_POST['cbogenero'];


    $respuesta  = $_pacientes->guardarPaciente($nombre,$telefono,$correo,$genero);
    if($respuesta == 0 ){
        echo "0";
    }else{
        print_r($respuesta);
    }


?>