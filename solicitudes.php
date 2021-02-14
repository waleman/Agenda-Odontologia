<?php
require_once 'clases/solicitudes.class.php';

$_solicitud  = new solicitud;
if(isset($_POST["btnbuscarsolicitud"])){
   $SolicitudId = $_solicitud->buscarSolicitudActiva();

   if($SolicitudId > 0){
      header("Location: firma.php?id=$SolicitudId");
   }

}


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SOLICITUDES</title>
    <link rel="stylesheet" href="theme/css/bootstrap.min.css">
</head>
<body>

<style>
        a {
        color: #92badd;
        display:inline-block;
        text-decoration: none;
        font-weight: 400;
        }

        h2 {
        text-align: center;
        font-size: 16px;
        font-weight: 600;
        text-transform: uppercase;
        display:inline-block;
        margin: 40px 8px 10px 8px; 
        color: #cccccc;
        }



        /* STRUCTURE */

        .wrapper {
        display: flex;
        align-items: center;
        flex-direction: column; 
        justify-content: center;
        width: 100%;
        min-height: 100%;
        padding: 20px;
        }

        #formContent {
        -webkit-border-radius: 10px 10px 10px 10px;
        border-radius: 10px 10px 10px 10px;
        background: #fff;
        padding: 30px;
        width: 90%;
        max-width: 450px;
        position: relative;
        padding: 0px;
        -webkit-box-shadow: 0 30px 60px 0 rgba(0,0,0,0.3);
        box-shadow: 0 30px 60px 0 rgba(0,0,0,0.3);
        text-align: center;
        }

        #formFooter {
        background-color: #f6f6f6;
        border-top: 1px solid #dce8f1;
        padding: 25px;
        text-align: center;
        -webkit-border-radius: 0 0 10px 10px;
        border-radius: 0 0 10px 10px;
        }





</style>

  <nav class="navbar navbar-expand-lg navbar-light bg-primary">
    <p class="navbar-brand" >Solicitudes</p>
  </nav>
  
  <div class="container">
  
  <div class="wrapper fadeInDown">
        <div id="formContent">
            <!-- Tabs Titles -->
            <br>

            <img src="public/imagenes/contrato.svg" alt="imagen de contrato" width="100"><br><br>
            <form method="post">
             <button type="submit" class="btn btn-primary" name="btnbuscarsolicitud">Consentimiento informado</button>
            </form>
            <br><br>

            <!-- Remind Passowrd -->
            <div id="formFooter">
            <a class="underlineHover" href="">Created by  Atenas Team</a>
            </div>

        </div>
   </div>

  
  </div>
</body>
</html>