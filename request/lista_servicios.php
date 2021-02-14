<?php
require_once '../clases/servicios.class.php';
$_servicios = new servicios;
$categoriaid= $_GET['id'];

$listaServicios = $_servicios->listaservicios($categoriaid);

foreach ($listaServicios as $key => $value) {
    $id= $value['ServicioId'];
    $nombre= $value['Nombre'];

    echo "
        <li class='list-group-item' id='$id'>
            $nombre
        </li>  
    ";
}

?>

