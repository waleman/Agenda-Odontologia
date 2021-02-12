<?php 
require_once '../clases/citas.class.php';
$_citas = new citas;

$id = $_GET['id'];
$listacitas = $_citas->obtenerCita($id);

$print = json_encode($listacitas);
print_r($print);
?>
  