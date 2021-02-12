<?php
require_once "../autoload/autoload.php";
session_start();
$_template = new template;
$_clinica = new clinica;
$_alertas = new alertas;

if(!isset($_SESSION['Parrot']['Usuario'])){
	header("Location: ../index.php");
	die();
}

echo $_template->abrir();





if(isset($_POST['btnguardarpaciente'])){

    $respuesta = $_clinica->editarClinica($_POST['txtnombre'],$_POST['txtdireccion'],$_POST['txtcorreo'],$_POST['txttelefono'],$_POST['txtweb'],$_POST['txtcif'],$_POST['txtcrc'],$_POST['txttitular'],$_POST['txtiban']);
    if($respuesta){
        echo $_alertas->success("Datos modificados ¡Correctamente!");
    }else{
        echo $_alertas->error("No se han modificados los datos");
    }

}

$datosClinica = $_clinica->datosClinica();

$nombre = $datosClinica['Nombre'];
$direccion = $datosClinica['Direccion'];
$correo = $datosClinica['Correo'];
$telefono = $datosClinica['Telefono'];
$cif =$datosClinica['CIF'];
$iban =$datosClinica['IBAN'];
$web = $datosClinica['Web'];
$crc = $datosClinica['CRC'];
$titular = $datosClinica['Titular'];
$Horainicio = $datosClinica['HoraInicio'];
$Horafin = $datosClinica['HoraFin'];
$lunes = $datosClinica['Lunes'];
$martes = $datosClinica['Martes'];
$miercoles = $datosClinica['Miercoles'];
$jueves = $datosClinica['Jueves'];
$viernes = $datosClinica['Viernes'];
$sabado = $datosClinica['Sabado'];
$domingo = $datosClinica['Domingo'];

?>



<div class="container-fluid">
    <div class="row">
        <div class="border-right col-sm-12">
                <div class="page-header">
                <h1 class="text-titles">Datos Personales</h1>
                </div>
                <form method="POST">
                                <div class="form-group col-sm-12">
                                    <div class="col-sm-3">
                                        <label for="txtnombre" style="color:#009688">Nombre de la empresa</label>
                                        <input type="text" class="form-control" id="txtnombre" name="txtnombre"  placeholder="Nombre del paciente" value="<?=$nombre?>">
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="txttelefono" style="color:#009688">Telefono</label>
                                        <input type="text" class="form-control" id="txttelefono" name="txttelefono"  placeholder="Telefono del paciente" value="<?=$telefono?>">
                                    </div>
                                </div>
                                <div class="form-group col-sm-12">
                                    <div class="col-sm-6">
                                        <label for="txtcorreo" style="color:#009688">Direccion</label>
                                        <input type="text" class="form-control" id="txtdireccion" name="txtdireccion"  placeholder="Direccion" value="<?=$direccion?>">
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="txttelefono" style="color:#009688">Correo</label>
                                        <input type="text" class="form-control" id="txtcorreo" name="txtcorreo"  placeholder="Whatasapp" value="<?=$correo?>">
                                    </div>
                                </div>
                                <div class="form-group col-sm-12">
                                    <div class="col-sm-3">
                                        <label for="txtnombre" style="color:#009688">Web</label>
                                        <input type="text" class="form-control" id="txtweb" name="txtweb"  placeholder="Pagina web" value="<?=$web?>">
                                    </div>
                             
                                    <div class="col-sm-3">
                                        <label for="txttelefono" style="color:#009688">CIF</label>
                                        <input type="text" class="form-control" id="txtcif" name="txtcif"  placeholder="CIF" value="<?=$cif?>">
                                    </div>

                                    <div class="col-sm-3">
                                        <label for="txttelefono" style="color:#009688">CRC</label>
                                        <input type="text" class="form-control" id="txtcrc" name="txtcrc"  placeholder="CRC" value="<?=$crc?>">
                                    </div>
                                </div>
                                <div class="form-group col-sm-12">
                                    <div class="col-sm-4">
                                        <label for="txtnombre" style="color:#009688">Titular</label>
                                        <input type="text" class="form-control" id="txttitular" name="txttitular"  placeholder="Titular" value="<?=$titular?>">
                                    </div>
                             
                                    <div class="col-sm-4">
                                        <label for="txttelefono" style="color:#009688">IBAN</label>
                                        <input type="text" class="form-control" id="txtiban" name="txtiban"  placeholder="CIF" value="<?=$iban?>">
                                    </div>

                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                    <br><br><br>
                                        <a href="calendario.php" class="btn btn-danger" style="background-color:#dc3545; color:#FFF" >Salir</a>
                                        <button type="submit" class="btn btn-primary" style="background-color:#17a2b8; color:#FFF" name="btnguardarpaciente" id="btnguardarpaciente">Guardar</button>
                                    </div>
                                </div>
                
                <form>
        </div>

    </div>
</div>


<?php
echo $_template->cerrar();
?>
