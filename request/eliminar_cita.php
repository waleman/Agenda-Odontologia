<?php
require_once '../clases/citas.class.php';
$_citas = new citas;

$citaId = $_GET['id'];

$resp = $_citas->eliminar($citaId);

if($resp){
    echo "1";
}else{
    echo "0";
}

?>