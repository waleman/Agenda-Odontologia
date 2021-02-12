<?php 
require_once '../clases/citas.class.php';
$_citas = new citas;
$listacitas = $_citas->listaCitas();

$mostrar = array();
foreach ($listacitas as $key => $value) {
    $fechamostrar =  $value['Fecha'] . "T" . $value['Inicio'];
    $fechafin = $value['Fecha'] . "T" .$value['Fin'];
    $estado = $value['Estado'];

    if($estado == "Activo"){
        $color = "#007fa3";
    }else{
        $color = "#CC9000";
    }
    
        $nuevo = array(
            'id'=> $value['CitaId'],
            'title'=> $value["Nombre"],
            'start'=> $fechamostrar ,
            'end' => $fechafin,
            'color' => $color,
            'Estado' => $estado
        );

     array_push($mostrar, $nuevo);

 }

$print = json_encode($mostrar);
print_r($print);
?>
