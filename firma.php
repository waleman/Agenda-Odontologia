<?php 
require_once 'clases/solicitudes.class.php';
$_solicitud = new solicitud;


$datosSolicitud = $_solicitud->obtenerTexto();
$finalidad = $datosSolicitud["Finalidad"];
$Legitimizacion = $datosSolicitud["Legitimizacion"]; 
$destinatarios = $datosSolicitud["Destinatarios"]; 
$derechos = $datosSolicitud["Derechos"]; 
$informacion = $datosSolicitud["Informacion"]; 
$titulo = $datosSolicitud["Titulo"];
$consentimientoTratamiento =$datosSolicitud["ConsentimientoTratamiento"];
$consentimientoTelefono =$datosSolicitud["ConsentimientoTelefono"];
$consentimientoSMS =$datosSolicitud["ConsentimientoSMS"];
$consentimientoEmail =$datosSolicitud["ConsentimientoEmail"];
$declara = $datosSolicitud['Declara'];


/*Datos de la clinica */ 
$CNombre= $_solicitud->obtenerNombreClinica();

if(!isset($_GET['id'])){
    header("Location: solicitudes.php");
}

$solicitudId = $_GET['id'];
$pacienteId = $_solicitud->obtenerPacienteIdSolicitud($solicitudId);
$datosPaciente = $_solicitud->buscarPacientePorId($pacienteId);
$Pnombre= $datosPaciente["Nombre"];
$PNIF= $datosPaciente["NIF"];
$Ptelefono= $datosPaciente["Telefono"];
$Pcorreo= $datosPaciente["Correo"];

if(isset($_POST['btnguardar'])){
    if(isset($_POST['consentimientoGeneral'])){ $general = 1;}else{ $general = 0;}
    if(isset($_POST['consentimientoTelefono'])){ $telefono = 1;}else{ $telefono = 0;}
    if(isset($_POST['consentimientosms'])){ $sms = 1;}else{$sms = 0;}
    if(isset($_POST['consentimientoEmail'])){ $email = 1;}else{ $email = 0;}
    $imagen = $_POST['imagen'];

    $verificar = $_solicitud->editarPaciente($pacienteId,$email,$telefono,$sms,$general);
    if($verificar){
        $name= $pacienteId . ".jpeg";
        $_solicitud->uploadImgBase64 ($imagen, $name);
        $_solicitud->actualizarSolicitud($solicitudId);
        header("Location: solicitudes.php");
    }



}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FIRMA</title>
    <link rel="stylesheet" href="theme/css/bootstrap.min.css">
    <link rel="stylesheet" href="theme/css/bootstrap-toggle.min.css">
    <script src="theme/js/jquery-3.1.1.min.js"></script>
    <script src="theme/js/bootstrap-toggle.min.js"></script>
</head>
<body>
    <style>
            table, td, th {
             border: 1px solid black;

            }
            table , td {
                padding: 5px;
            }

            table {
            width: 100%;
            border-collapse: collapse;
            }
    </style>

    <div class="container">
       <form method="post" ENCTYPE='multipart/form-data'>
        <div class="col-lg-12 col-md-12 col-xs-12">
            <h3><?=$titulo?></h3>
            <br>
            <h4>DATOS DEL PACIENTE</h4>
                <table style="width:60%">
                    <tr>
                        <td><b>Nombre</b> :<?= $Pnombre?> </td>
                        <td><b>NIF</b>:<?= $PNIF?>  </td>
                    </tr>
                    <tr>
                        <td><b>Telefono</b>:<?= $Ptelefono?> </td>
                        <td><b>Correo</b>:<?= $Pcorreo?>  </td>
                    </tr>
                </table>
            <br>
                <h4>INFORMACION BASICA SOBRE PROTECCION DE DATOS</h4>
                    <table style="width:80%">
                        <tr>
                            <td>Responsable</td>
                            <td><?=$CNombre?></td>
                        </tr>
                        <tr>
                            <td>Finalidad</td>
                            <td><?= $finalidad?>  </td>
                        </tr>
                        <tr>
                            <td>Legitimización</td>
                            <td><?= $Legitimizacion?>  </td>
                        </tr>
                        <tr>
                            <td>Destinatarios</td>
                            <td><?= $destinatarios?>  </td>
                        </tr>
                        <tr>
                            <td>Derechos</td>
                            <td><?= $derechos?>  </td>
                        </tr>
                        <tr>
                            <td>Información Adicional</td>
                            <td><?= $informacion?>  </td>
                        </tr>
                    </table>
                <br>
                <h4>Consentimiento</h4>   
                    <table style="width:80%">
                        <tr>
                            <td><b>Si / No</b> </td>
                            <td><b>Consentimiento</b></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="checkbox">
                                    <label>
                                        <input name="consentimientoGeneral" type="checkbox" data-toggle="toggle" checked>
                                    </label>
                                </div>
                            </td>
                            <td><?=$consentimientoTratamiento?></td>
                        </tr>
                        <tr>
                            <td> 
                                <div class="checkbox">
                                    <label>
                                        <input name="consentimientoTelefono" type="checkbox" data-toggle="toggle">
                                    </label>
                                </div>
                            </td>
                            <td><?=$consentimientoTelefono?></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="checkbox">
                                    <label>
                                        <input  name="consentimientosms" type="checkbox" data-toggle="toggle">
                                    </label>
                                </div>
                            </td>
                            <td><?=$consentimientoSMS?></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="checkbox">
                                    <label>
                                        <input name="consentimientoEmail" type="checkbox" data-toggle="toggle">
                                    </label>
                                </div>
                            </td>
                            <td><?=$consentimientoEmail?></td>
                        </tr>
                        
                    </table>
                <br>
        </div>
        <div class="col-lg-12 col-md-12 col-xs-12">
                <h4>Declara que ha sido informado de lo siguiente:</h4>
                 <p style="width:80%"><?=$declara?></p>
        </div>
               <br>
               <div style="text-align:center">
               
                 <canvas id='canvas' height="200" width="550px" style=" border: 1px solid #007bff; ">
                     <p>Tu navegador no soporta canvas</p>
                 </canvas>
                 <p>FIRMA</p>
               </div>
               </div>
               <input type='hidden' name='imagen' id='imagen' />
               <script type="text/javascript">
                                            var idCanvas='canvas';
                                            var idForm='formCanvas';
                                            var inputImagen='imagen';
                                            var estiloDelCursor='crosshair';
                                            var colorDelTrazo='#555';
                                            var colorDeFondo='#fff';
                                            var grosorDelTrazo=2;

                                            var contexto=null;
                                            var valX=0;
                                            var valY=0;
                                            var flag=false;
                                            var imagen=document.getElementById(inputImagen);
                                            var anchoCanvas=document.getElementById(idCanvas).offsetWidth;
                                            var altoCanvas=document.getElementById(idCanvas).offsetHeight;
                                            var pizarraCanvas=document.getElementById(idCanvas);

                                            window.addEventListener('load',IniciarDibujo,false);

                                            function IniciarDibujo(){
                                                pizarraCanvas.style.cursor=estiloDelCursor;
                                                contexto=pizarraCanvas.getContext('2d');
                                                contexto.fillStyle=colorDeFondo;
                                                contexto.fillRect(0,0,anchoCanvas,altoCanvas);
                                                contexto.strokeStyle=colorDelTrazo;
                                                contexto.lineWidth=grosorDelTrazo;
                                                contexto.lineJoin='round';
                                                contexto.lineCap='round';
                                                pizarraCanvas.addEventListener('mousedown',MouseDown,false);// Click pc
                                                pizarraCanvas.addEventListener('mouseup',MouseUp,false);// fin click pc
                                                pizarraCanvas.addEventListener('mousemove',MouseMove,false);// arrastrar pc
                                                pizarraCanvas.addEventListener('touchstart',TouchStart,false);// tocar pantalla tactil
                                                pizarraCanvas.addEventListener('touchmove',TouchMove,false);// arrastras pantalla tactil
                                                pizarraCanvas.addEventListener('touchend',TouchEnd,false);// fin tocar pantalla dentro de la pizarra
                                                pizarraCanvas.addEventListener('touchleave',TouchEnd,false);// fin tocar pantalla fuera de la pizarra
                                            }

                                            function MouseDown(e){
                                            flag=true;
                                            contexto.beginPath();
                                            valX=e.pageX-posicionX(pizarraCanvas); valY=e.pageY-posicionY(pizarraCanvas);
                                            contexto.moveTo(valX,valY);
                                            }

                                            function MouseUp(e){
                                            contexto.closePath();
                                            flag=false;
                                            }

                                            function MouseMove(e){
                                            if(flag){
                                                contexto.beginPath();
                                                contexto.moveTo(valX,valY);
                                                valX=e.pageX-posicionX(pizarraCanvas); valY=e.pageY-posicionY(pizarraCanvas);
                                                contexto.lineTo(valX,valY);
                                                contexto.closePath();
                                                contexto.stroke();
                                            }
                                            }

                                            function TouchMove(e){
                                            e.preventDefault();
                                            if (e.targetTouches.length == 1) {
                                                var touch = e.targetTouches[0];
                                                MouseMove(touch);
                                            }
                                            }

                                            function TouchStart(e){
                                            if (e.targetTouches.length == 1) {
                                                var touch = e.targetTouches[0];
                                                MouseDown(touch);
                                            }
                                            }

                                            function TouchEnd(e){
                                            if (e.targetTouches.length == 1) {
                                                var touch = e.targetTouches[0];
                                                MouseUp(touch);
                                            }
                                            }

                                            function posicionY(obj) {
                                            var valor = obj.offsetTop;
                                            if (obj.offsetParent) valor += posicionY(obj.offsetParent);
                                            return valor;
                                            }

                                            function posicionX(obj) {
                                            var valor = obj.offsetLeft;
                                            if (obj.offsetParent) valor += posicionX(obj.offsetParent);
                                            return valor;
                                            }

                                            /* Limpiar pizarra */
                                            function LimpiarTrazado(){
                                            contexto=document.getElementById(idCanvas).getContext('2d');
                                            contexto.fillStyle=colorDeFondo;
                                            contexto.fillRect(0,0,anchoCanvas,altoCanvas);
                                            }

                                            /* Enviar el trazado */
                                            function GuardarTrazado(){
                                            imagen.value=document.getElementById(idCanvas).toDataURL('image/png');
                                            document.forms[idForm].submit();
                                            }
               </script>
            </div>
            <div class="row" style="text-align:center">
              <div class="col-lg-8 col-md-12 col-xs-12 " >
                  <button type="submit" class="btn btn-primary btn-lg " name="btnguardar" id="btnguardar" onclick='GuardarTrazado()'>Finalizar</button>
                  <a href="solicitudes.php"  class="btn btn-danger btn-lg " >Cancelar</a>
                  <br><br><br><br>
              </div>
            </div>          
        </form> 
    </div>
</body>
</html>