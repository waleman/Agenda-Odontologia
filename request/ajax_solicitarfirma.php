<?php
require_once '../clases/solicitudes.class.php';
$_solicitud = new solicitud;
$paciente = $_GET['id'];
$solicitudId = $_solicitud->crearsolicitud($paciente);


$i = 0;
while ($i == 0) :
        $espera = $_solicitud->verEstadoSolicitud($solicitudId);
        echo "el estado es $espera";
        if($espera == 'Inactivo'){
                $i = 1;
        }
    sleep(3);
endwhile;




?>