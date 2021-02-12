<?php
require_once '../clases/presupuestos.class.php';
$_presupuestos = new presupuestos;

$detallepresupuestoid = $_POST['detallepresupuestoid'];
$presupuestoid = $_POST['presupuestoid'];

$_presupuestos->eliminarDetalle($detallepresupuestoid);

echo $_presupuestos->impirmirTabla($presupuestoid)



?>