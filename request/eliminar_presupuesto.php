<?php
require_once '../clases/presupuestos.class.php';
$_presupuestos = new presupuestos;


$presupuestoId = $_POST['presupuestoId'];
$_presupuestos->eliminarPresupuesto($presupuestoId);