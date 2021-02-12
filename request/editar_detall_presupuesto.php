<?php
require_once '../clases/presupuestos.class.php';

$_presupuestos = new presupuestos;


$detallepresupuestoid = $_POST['detallepresupuestoid'];
$observacion = $_POST['observaciones'];
$presupuestoid = $_POST['presupuestoid'];

$editar = $_presupuestos->editarComentario($detallepresupuestoid,$observacion);

echo $_presupuestos->impirmirTabla($presupuestoid)


?>