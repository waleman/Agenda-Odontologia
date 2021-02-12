<?php
require_once '../terceros/composer/vendor/autoload.php';
require_once '../clases/presupuestos.class.php';
require_once '../clases/clinica.class.php';
require_once '../clases/pacientes.class.php';
use Spipu\Html2Pdf\Html2Pdf;
$html2pdf = new Html2Pdf;
$_clinica = new clinica;
$_presupuestos = new presupuestos;
$_pacientes = new pacientes;


//variables enviadas por URL
$presupuestoid = $_GET['presupuesto'];
$pacienteid = $_GET['paciente'];

//datos de la clinica
    $DatosClinica = $_clinica->datosClinica();
    $nombreClinica = $DatosClinica['Nombre'];
    $direccionClinica = $DatosClinica['Direccion'];
    $telefonoClinica =$DatosClinica['Telefono'];
    $correoClinica = $DatosClinica['Correo'];
    $webClinica = $DatosClinica['Web'];
    $fecha = date("d-m-Y");
    $contador = 1;
    $total = 0;

//datos del presupuesto

    $DatosPresupuesto = $_presupuestos->obtenerDetallePresupuesto($presupuestoid);

//datos del paciente
    $DatosPaciente  = $_pacientes->buscarPacientePorId($pacienteid);
    $pacienteNombre = $DatosPaciente[0]['Nombre'];
    $pacienteTelefono =  $DatosPaciente[0]['Telefono'];
    $pacienteDNI =  $DatosPaciente[0]['NIF'];
    $pacienteCorreo =  $DatosPaciente[0]['Correo'];

//impirmir documento
    $html = "<page backtop='7mm' backbottom='0mm' backleft='10mm' backright='10mm'>";
    $html .= "<div style='right:0px; position:absolute;'><img src='../public/logo/logo.png' alt='Logo' style='height:150px; width:150px;'></div>";
    $html .= "<style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            padding:5px;
        }
        .centertext{
            text-align:center
        }
    </style>";
    $html .="<br><h3 style='left:260px; margin-bottom: 0px;'>$nombreClinica</h3>
             <p style='margin-top: 1px'>$direccionClinica<br>
                $telefonoClinica<br>
                $correoClinica<br>
                $webClinica</p>
    ";
    $html .= "<h3 class='centertext' >PRESUPUESTO</h3>";
    $html .= "<br>
        <div style='width: 650px;'>
        <table style='width:100%;' >
            <tr>
                <td style='width:100%;'colspan='3' ><b>Nombre:</b>$pacienteNombre </td>
            </tr>
            <tr>
                <td style='width:30%;' ><b>DNI:</b> $pacienteDNI </td>
                <td style='width:30%;'><b>Telefono:</b> $pacienteTelefono </td>
                <td style='width:40%;'><b>Correo:</b> $pacienteCorreo </td>
            </tr>
        </table>
        </div>
    ";
    $html .= "<br><br>
    <div style='width: 650px;'>
        <table style='width:100%;' >
            <tr>
                <th style='width:5%;'  > Nº </th>
                <th style='width:60%;' > Descripcion </th>
                <th style='width:10%;' > Nº Pieza </th>
                <th style='width:10%;' > Cara </th>
                <th style='width:15%;' > Precio </th>
            </tr>";
           

            foreach ($DatosPresupuesto as $key => $value) {
                $diente = $value['Diente'];
                $cara = $value['Cara'];
                $servicio = $value['Servicio'];
                $precio = $value['Precio'];
                if($cara == ""){ $cara = "-";}
                
                $html .= "<tr>
                    <td style='width:5%;'  >$contador</td>
                    <td style='width:60%px;' >$servicio</td>
                    <td style='width:10%px;' >$diente</td>
                    <td style='width:10%px;' >$cara</td>
                    <td style='width:10%px; text-align:right;' >$precio €</td>
                </tr>";
                
                $total = $total + $precio;
                $contador ++;
            }
      $total = number_format($total, 2, '.', ',') ;    
     $html .="</table>
        <h4 style='text-align:right;'>Total : $total €</h4>
    </div>
    <div style='width: 650px;'>
        <h5>Notas: </h5>
        <span>Cualquier otro tratamiento se presupuestará aparte.</span><br>
        <span>Este presupuesto tiene una validez de 6 meses y queda sujeto a posibles modificaciones una vez iniciado el tratamiento.</span><br>
        <span><b>Los pagos se realizarán al contado y por trabajo realizado.</b></span><br>
        <span><b>En trabajos de prótesis se abonara el 50% al empezar el tratamiento.</b></span><br>
        <span>Garantía en obturaciones (6 meses)</span>
        <span>Garantía en prótesis fijas y removibles (1 año)</span>

    </div>
    ";
    $html .= "</page>";

   // echo $html;

    $html2pdf->writeHTML($html);
    $html2pdf->output();


?>