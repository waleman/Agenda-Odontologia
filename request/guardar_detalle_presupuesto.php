<?php
require_once '../clases/presupuestos.class.php';

$_presupuestos = new presupuestos;

$presupuestoid = $_POST['presupuestoid'];

$dienteid = $_POST['id'];
$cara = $_POST['cara'] ;
$caraid = $_POST['caraid'];
$observacion = $_POST['observacion'];

$servicioid = $_POST['servicio']['ServicioId'];
$servicio = $_POST['servicio']['Nombre'];


$categoria = $_POST['categoria'];
$categoriaid = $_POST['servicio']['CategoriaId'];

$precio = $_POST['servicio']['Precio'];
$iva = $_POST['servicio']['IVA'];
$estado = $_POST['servicio']['Estado'];


$_presupuestos->gudardarDetallePresupuesto($presupuestoid,$servicioid,$servicio,$categoriaid,$categoria,$dienteid,$caraid,$cara,$observacion,$estado,$precio,$iva);

echo $_presupuestos->impirmirTabla($presupuestoid)


?>

