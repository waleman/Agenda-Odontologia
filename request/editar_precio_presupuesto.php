<?php
require_once '../clases/presupuestos.class.php';

$_presupuestos = new presupuestos;


$detallepresupuestoid = $_POST['detallepresupuestoid'];
$precio = $_POST['precio'];
$presupuestoid = $_POST['presupuestoid'];

$editar = $_presupuestos->editarPrecio($detallepresupuestoid,$precio);

echo $_presupuestos->impirmirTabla($presupuestoid)

?>