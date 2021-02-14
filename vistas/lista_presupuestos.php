<?php
require_once "../autoload/autoload.php";
session_start();
$_template = new template;
$_pacientes = new pacientes;
$_alertas = new alertas;
$_presupuestos = new presupuestos;

if(!isset($_SESSION['Parrot']['Usuario'])){
	header("Location: ../index.php");
	die();
}
$usuarioId = $_SESSION['Parrot']['UsuarioId'];
echo $_template->abrir();
echo "<link href='../theme/css/tabs.css' rel='stylesheet'>";
$pacienteId = $_GET['pacienteId'];

if(isset($_POST['btnguardar'])){
    $nombre = $_POST['txtnombre'];
    $resp = $_presupuestos->crearPresupuesto($pacienteId,$usuarioId,$nombre,$usuarioId);
    if($resp > 0){
        echo "<script>window.location.replace('presupuesto.php?id=' + $resp + '&paciente=$pacienteId');</script>";
    }else{
        Echo "aqui una alerta";
    }
 }


$listaPresupuestos = $_presupuestos->obtenerPresupuestosPaciente($pacienteId);


?>

  
<div class="container-fluid"> 
    <div class="row">
        <div class="border-right col-10 col-sm-10">
                <div class="page-header">
                    <ul class="nav nav-tabs">
                        <li class="tab"><a href="detalle_paciente.php?pacienteId=<?=$pacienteId?>">Datos personales</a></li>
                        <li class="tab tabactive"><a href="lista_presupuestos.php?pacienteId=<?=$pacienteId?>">Presupuestos</a></li>

                    </ul>
                     <h3 class="text-titles">Lista de presupuestos</h3>
                </div>
                
                    <button type="submit" class="btn btn-primary" style="background-color:#2c3e50; color:#FFF" name="btnnuevo" id="btnnuevo">Crear nuevo presupuesto</button>
             


                <table class="table  table-hover table-striped table-bordered w-auto">
                    <thead>
                        <tr  class="bg-primary">
                            <th scope="col">Codigo</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Fecha de creacion</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            if(!empty($listaPresupuestos)){
                                foreach ($listaPresupuestos as $key => $value) {
                                    $nombre = $value['Nombre'];
                                    $presupuestoId = $value['PresupuestoId'];
                                    $fecha = $value['Fecha'];
                                    $codigo = $value['Codigo'];
                                    echo "
                                        <tr data-id='$presupuestoId' data-paciente='$pacienteId'>
                                            <td >$codigo</td>
                                            <td >$nombre</td>
                                            <td>$fecha</td>
                                            <td>  <a data-borrar='$presupuestoId' class='btn btn-danger btn-raised btn-xs'><i class='zmdi zmdi-delete'></i><div class='ripple-container'></div></a></td>
                                        </tr>
                                    ";
                                 }
                            }else{
                                echo "
                                    <tr>
                                        <td ></td>
                                        <td >Auno no existen prespuestos creados para este paciente</td>
                                        <td></td>
                                    </tr>
                                ";
                            }
                        ?>
                    </tbody>
                </table>

        </div>
    </div>
</div> 

 <!-- Nuevo presupuestos -->
 <div class="modal modal-md" tabindex="-1" role="dialog" id="modal-crearpresupuesto">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h3 class="modal-title">Nuevo presupuesto</h3>
					</div>
					<form method="POST">
						<div class="modal-body">
													
							<div class="form-group">
								<div class="col-sm-8">
									<label for="txtfecha"  style="color:#009688">Nombre del presupuesto</label>
									<input type="text" class="form-control" id="txtnombre" name="txtnombre"  placeholder="Nombre del presupuesto">
								</div>
							</div>


						</div>
						<div class="modal-footer">
							<div class="form-group">
								<div class="col-sm-12">
								<br><br>

									<button type="button" class="btn btn-danger" style="background-color:#dc3545; color:#FFF;" data-dismiss="modal">Salir</button>
									<button type="submit" class="btn btn-primary" style="background-color:#17a2b8; color:#FFF" name="btnguardar" id="btnguardar">Crear</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
</div>      



<?php
echo "<script type='text/javascript' src='js/lista_presupuestos.js'></script>";
echo $_template->cerrar();
?>