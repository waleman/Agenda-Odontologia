<?php
require_once "../autoload/autoload.php";
session_start();
$_template = new template;
$_pacientes = new pacientes;
$_consultas = new consultas;
$_alertas = new alertas;

if(!isset($_SESSION['Parrot']['Usuario'])){
	header("Location: ../index.php");
	die();
}

$usuarioId = $_SESSION['Parrot']['Usuario'];

echo $_template->abrir();
echo "<link href='../theme/css/tabs.css' rel='stylesheet'>";


if(!isset($_GET['pacienteId'])){
    echo "<script>
      window.location.replace('lista_pacientes.php');
    </script>";
    die();
}

$pacienteId = $_GET['pacienteId'];
echo"<script>let pacienteId = $pacienteId;</script>";

if(isset($_POST['btnguardarpaciente'])){
    $codigo = $_POST['txtcodigo'];
    $nombre = $_POST['txtnombre'];
    $nif = $_POST['txtnif'];
    $direccion = $_POST['txtdireccion'];
    $codigoPostal = $_POST['txtcodigopostal'];
    if(isset($_POST['cbopais'])){$pais = $_POST['cbopais'];}else{ $pais = "";}
    if(isset($_POST['cbopoblacion'])){ $poblacion = $_POST['cbopoblacion'];}else{ $poblacion = "";}
    if(isset($_POST['cboprovincia'])){ $provincia = $_POST['cboprovincia'];}else{ $provincia = "";}
    $genero = $_POST['cbogenero'];
    $correo = $_POST['txtcorreo'];
    $telefono = $_POST['txttelefono'];
    $fechaNac = $_POST['txtfechanac'];
    $alergias = $_POST['txtalergia'];
    $observaciones = $_POST['txtobservaciones'];

    $respuesta = $_pacientes->editarPaciente($codigo,$nombre,$nif,$direccion,$pais,$provincia,$poblacion,$genero,$correo,$telefono,$fechaNac,$alergias,$observaciones,$pacienteId);
    if($respuesta){
        echo $_alertas->success("Datos modificados ¡Correctamente!");
    }else{
        echo $_alertas->error("No se han modificados los datos");
    }

}
 
/* CARGAMOS TODOS LOS DATOS RELACIONADOS CON EL PACIENTE */

    $datosPaciente = $_pacientes->buscarPacientePorId($pacienteId);

    if($datosPaciente == array()){
        echo "<script>
            window.location.replace('lista_pacientes.php');
        </script>";
        die();
    }else{
        echo "<script>
        let usuarioId = '$usuarioId';
        </script>";
    }

    $codigo = $datosPaciente[0]['Codigo'];
    $nombre = $datosPaciente[0]['Nombre'];
    $nif = $datosPaciente[0]['NIF'];
    $direccion = $datosPaciente[0]['NIF'];
    $codigoPostal = $datosPaciente[0]['CodigoPostal'];
    $pais = $datosPaciente[0]['PaisId'];
    $provincia = $datosPaciente[0]['ProvinciaId'];
    $poblacion = $datosPaciente[0]['LocalidadId'];
    $Genero = $datosPaciente[0]['Genero'];
    $fechaNacimiento = $datosPaciente[0]['FechaNacimiento'];
    $consentimientoEstado = $datosPaciente[0]['ConsentimientoEstado'];
    $consentimientoEmail = $datosPaciente[0]["ConsentimientoEmail"];
    $consentimientoTelefono = $datosPaciente[0]["ConsentimientoTelefono"];
    $consentimientoSMS = $datosPaciente[0]["ConsentimientoSMS"];
    $consentimientoTratamiento = $datosPaciente[0]["ConsentimientoTratamiento"];

    if($fechaNacimiento != ""){
        $edad = $_pacientes->edad($fechaNacimiento);
    }else {
        $edad = "-";
    }

    $date = new DateTime($fechaNacimiento);
    $fechaNacimiento = $date->format('Y-m-d');

    $correo = $datosPaciente[0]['Correo'];
    $telefono = $datosPaciente[0]['Telefono'];
    $alergias = $datosPaciente[0]['Alergias'];
    $antecedentes = $datosPaciente[0]['Antecedentes'];


    $ListaPaises = $_pacientes->obtenerPaises();
    $ListaProvincias = $_pacientes->obtenerProvincias($pais);
    $ListaPoblaciones = $_pacientes->obtenerPoblaciones($provincia);


?>



<div class="container-fluid">
    <div class="row">
        <div class="border-right col-10 col-sm-10">
                <div class="page-header">
              
                <ul class="nav nav-tabs">
                    <li class="tab tabactive"><a href="#">Datos personales</a></li>
                    <li class="tab"><a href="lista_presupuestos.php?pacienteId=<?=$pacienteId?>">Presupuestos</a></li>
                    <!-- <li><a href="#">Menu 2</a></li>
                    <li><a href="#">Menu 3</a></li> -->
                 </ul>
                 <h3 class="text-titles">Datos Personales</h3>
                </div>
                <form method="POST">
                                <div class="form-group">
                                    <div class="col-sm-3">
                                        <label for="txtnombre" style="color:#009688">Codigo</label>
                                        <input type="text" class="form-control" id="txtcodigo" name="txtcodigo"  placeholder="Codigo" value="<?=$codigo?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="txtnombre" style="color:#009688">Paciente</label>
                                        <input type="text" class="form-control" id="txtnombre" name="txtnombre"  placeholder="Nombre del paciente" value="<?=$nombre?>">
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="txtnombre" style="color:#009688">NIF</label>
                                        <input type="text" class="form-control" id="txtnif" name="txtnif"  placeholder="NIF" value="<?=$nif?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-9">
                                        <label for="txttelefono" style="color:#009688">Direccion</label>
                                        <input type="text" class="form-control" id="txtdireccion" name="txtdireccion"  placeholder="Direccion del paciente" value="<?=$direccion?>">
                                    </div>  
                                    <div class="col-sm-3">
                                        <label for="txttelefono" style="color:#009688">Codigo postal</label>
                                        <input type="text" class="form-control" id="txtcodigopostal" name="txtcodigopostal"  placeholder="CP" value="<?=$codigoPostal?>">
                                    </div>                                    
                                </div>
                                <div class="form-group ">
                                    <div class="col-sm-3">
                                        <label for="cbopais" style="color:#009688">Pais</label>
                                        <select class="form-control" id="cbopais" name="cbopais">
                                          <option value='0' selected disabled>- Seleccione un pais -</option>
                                            <?php 
                                                foreach ($ListaPaises as $key => $value) {
                                                    $paisId= $value['PaisId'];
                                                    $paisNombre = $value['Nombre'];
                                                    if($paisId == $pais){
                                                        echo "
                                                        <option value='$paisId' selected>$paisNombre</option>
                                                        ";
                                                    }else{
                                                        echo "
                                                        <option value='$paisId' >$paisNombre</option>
                                                        ";
                                                    }

                                                }
                                            ?>
                                        </select>
                                    </div>  
                                    <div class="col-sm-3" id="divprovincia">
                                        <label for="cboprovincia" style="color:#009688">Provincia</label>
                                        <select class="form-control" id="cboprovincia" name="cboprovincia">
                                          <option value='0' selected disabled>- Seleccione Provincia -</option>
                                            <?php 
                                                foreach ($ListaProvincias as $key => $value) {
                                                    $provinciaId= $value['ProvinciaId'];
                                                    $provinciaNombre = $value['Nombre'];
                                                    if($provinciaId == $provincia){
                                                        echo "
                                                        <option value='$provinciaId' selected>$provinciaNombre</option>
                                                        ";
                                                    }else{
                                                        echo "
                                                        <option value='$provinciaId' >$provinciaNombre</option>
                                                        ";
                                                    }

                                                }
                                            ?>
                                        </select>
                                    </div>  
                                    <div class="col-sm-3" id="divpoblacion">
                                        <label for="cbogenero" style="color:#009688">Poblacion</label>
                                        <select class="form-control" id="cbopoblacion" name="cbopoblacion">
                                          <option value='0' selected disabled>- Seleccione una poblacion -</option>
                                            <?php 
                                                foreach ($ListaPoblaciones as $key => $value) {
                                                    $poblacionId= $value['LocalidadId'];
                                                    $poblacionNombre = $value['Nombre'];
                                                    if($poblacionId == $poblacion){
                                                        echo "
                                                            <option value='$poblacionId' selected>$poblacionNombre</option>
                                                        ";
                                                    }else{
                                                        echo "
                                                          <option value='$poblacionId' >$poblacionNombre</option>
                                                        ";
                                                    }

                                                }
                                            ?>
                                        </select>
                                    </div>  
                                                                  
                                          
                                    <div class="col-sm-3">
                                        <label for="cbogenero" style="color:#009688">Genero</label>
                                        <select class="form-control" id="cbogenero" name="cbogenero">
                                            <?php 
                                                if($Genero == "M"){
                                                    echo "
                                                    <option value='M' selected>Masculino</option>
                                                    <option value='F'>Femenino</option>
                                                    ";
                                                }else{
                                                    echo "
                                                    <option value='M' >Masculino</option>
                                                    <option value='F' selected>Femenino</option>
                                                    ";
                                                }
                                            ?>

                                        </select>
                                    </div>         

                                </div>
                                <div class="form-group">
                                    <div class="col-sm-3">
                                        <label for="txtcorreo" style="color:#009688">Correo</label>
                                        <input type="text" class="form-control" id="txtcorreo" name="txtcorreo"  placeholder="Correo del paciente" value="<?=$correo?>">
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="txttelefono" style="color:#009688">Telefono</label>
                                        <input type="text" class="form-control" id="txttelefono" name="txttelefono"  placeholder="Telefono del paciente" value="<?=$telefono?>">
                                    </div>
                                </div>
                                <div class="form-group">                                  
                                    <div class="col-sm-3">
                                        <label for="txttelefono" style="color:#009688">Fecha Nacimiento</label>
                                        <input type="date" class="form-control" id="txtfechanac" name="txtfechanac" value="<?=$fechaNacimiento?>">
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="txttelefono" style="color:#009688">Edad</label>
                                        <input type="text" class="form-control" id="txtedad" name="txtedad"  placeholder="Telefono del paciente" value="<?=$edad?>" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-6">
                                        <div class="input-group" style="width:100%">
                                            <label for="txtmotivo" style="color:#009688">Alergias/Contraindicaciones</label>
                                            <textarea class="form-control <?php if($alergias != ""){ echo "alergias";} ?> " name="txtalergia" id="txtalergia" rows="3" ><?=$alergias?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="input-group" style="width:100%">
                                            <label for="txtantecedentes" style="color:#009688">Observaciones/Antecedentes</label>
                                            <textarea class="form-control" name="txtobservaciones" id="txtobservaciones" rows="3" style="border:1 !important;"><?=$antecedentes?></textarea>
                                        </div>
                                    </div>
                               </div> 

                               <div class="form-group col-sm-12">      
                                    <fieldset class="fieldset">
                                    <legend class="legend">Consentimiento informado </legend>    
                                                
                                    <?php 

                                    if($consentimientoEstado == 1){
                                    ?>
                                    
                                    
                                        <div class="col-sm-2">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="checksms" name="checksms" <?php if($consentimientoSMS){ echo "checked";} ?> >
                                                <label for="txttelefono" style="color:#009688">SMS</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="checkemail" name="checkemail" <?php if($consentimientoEmail){ echo "checked";} ?> >
                                                <label for="txttelefono" style="color:#009688">Email</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="checktelefono" name="checktelefono" <?php if($consentimientoTelefono){ echo "checked";} ?> >
                                                <label for="txttelefono" style="color:#009688">Telefono</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-5">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="checktratamiento" name="checktelefono" <?php if($consentimientoTratamiento){ echo "checked";} ?> >
                                                <label for="txttratamiento" style="color:#009688">Realizar Tratamiento</label>
                                            </div>
                                        </div>
                                    <?php 
                                    }else{
                                        echo "
                                            <div class='col-sm-12' style='text-align:center;'>
                                                <a href='' class='btn' id='btnsolicitarfirma' style='background: #ff5722; color: white;'> Solicitar consentimiento </a>
                                            </div>
                                        ";
                                    
                                    }
                                    ?>
                                    </fieldset>    
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                    <br><br>
                                        <a href="lista_pacientes.php" class="btn btn-danger" style="background-color:#dc3545; color:#FFF" >Salir</a>
                                        <button type="submit" class="btn btn-primary" style="background-color:#17a2b8; color:#FFF" name="btnguardarpaciente" id="btnguardarpaciente">Guardar</button>
                                    </div>
                                </div>
                
                <form>
        </div>
       
    </div>

  
</div>

<div class="loader" style="display:none">
                <div class="divcenter">
                       <h1>Esperando firma del paciente</h1>
                       <img src="../public/imagenes/loading.gif" alt="">
                </div>
</div>

    
</div>

<?php
echo "<script type='text/javascript' src='js/detalle_paciente.js'></script>";
echo $_template->cerrar();
?>
