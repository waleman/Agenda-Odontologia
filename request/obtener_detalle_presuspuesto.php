<?php
require_once '../clases/presupuestos.class.php';
$_presupuestos = new presupuestos;

$presupuestoDetalleId = $_POST['presupuestoDetalleId'];

$Datos = $_presupuestos->obtenerDetallePorId($presupuestoDetalleId);

echo json_encode($Datos);

?>