<?php 
require_once '../clases/citas.class.php';
$_citas = new citas;

$id = $_POST['id'];
$fecha = $_POST['fecha'];
$inicio = $_POST['inicio'];
$fin = $_POST['fin'];

$resp = $_citas->modificarDragAndDrop($id,$fecha,$inicio,$fin);
if($resp){
    echo "1";
}else{
    echo "0";
}


?>