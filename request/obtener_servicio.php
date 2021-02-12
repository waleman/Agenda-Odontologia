<?php 
require_once '../clases/servicios.class.php';
$_servicios = new servicios;

$id = $_GET['id'];
$servicio = $_servicios->obtenerServicio($id);

$print = json_encode($servicio);
print_r($print);
?>
