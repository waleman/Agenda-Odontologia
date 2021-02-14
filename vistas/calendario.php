<?php
require_once "../autoload/autoload.php";
session_start();
$_template = new template;
$_pacientes = new pacientes;
$_citas = new citas;
$_alertas = new alertas;
$_consultas = new consultas;



 
//print_r($_template->checkLogin());
 

if(!isset($_SESSION['Parrot']['Usuario'])){
	header("Location: ../index.php");
	die();
}




echo $_template->abrir();


	/* js y css adicional */
	echo "
    <link href='../terceros/fullcalendar/packages/core/main.css' rel='stylesheet' />
    <link href='../terceros/fullcalendar/packages/daygrid/main.css' rel='stylesheet' />
    <link href='../terceros/fullcalendar/packages/timegrid/main.css' rel='stylesheet' />
    <link href='../terceros/fullcalendar/packages/list/main.css' rel='stylesheet' />
    <link href='../theme/css/calendario.css' rel='stylesheet' />
    <script src='../terceros/fullcalendar/packages/core/main.js'></script>
    <script src='../terceros/fullcalendar/packages/core/locales-all.js'></script>
    <script src='../terceros/fullcalendar/packages/interaction/main.js'></script>
    <script src='../terceros/fullcalendar/packages/daygrid/main.js'></script>
    <script src='../terceros/fullcalendar/packages/timegrid/main.js'></script>
    <script src='../terceros/fullcalendar/packages/list/main.js'></script> 
	 ";

if(isset($_POST['btnguardar']))	{
	$pacienteid = $_POST['txtpacienteid'];
	$fecha = $_POST['txtfecha'];
	$inicio = $_POST['txthorainicio'];
	$fin = $_POST['txthorafin'];
	$motivo = $_POST['txtmotivo'];

	$respuesta = $_citas->guardarCita($pacienteid,$fecha,$inicio,$fin,$motivo);
	if($respuesta){
		echo $_alertas->success("¡Correcto! Cita creada");
	}else{
		echo $_alertas->error("¡Error! al crear la Cita");
	}
}

if(isset($_POST['btnguardar_editar'])){
	$fecha = $_POST['txtfecha_editar'];
	$inicio = $_POST['txthorainicio_editar'];
	$fin = $_POST['txthorafin_editar'];
	$citaid = $_POST['txtcodigo_cita'];
	$motivo = $_POST['txtmotivo_editar'];
	$resp = $_citas->editarCita($fecha,$inicio,$fin,$motivo,$citaid);
	if($resp){
		echo $_alertas->success("¡Correcto¡ Cita modificada");
	}else{
		echo $_alertas->error("No se han realizado cambios");
	}
}

if(isset($_POST['btnconsulta'])){
	$citaId = $_POST['txtcodigo_cita'];
	$pacienteId = $_citas->obtenerPacienteIdDesdeCita($citaId);
		if($pacienteId > 0){
			echo "<script>
					window.location.replace('detalle_paciente.php?pacienteId=$pacienteId');
				  </script>";
		}else{
			echo $_alertas->error("¡Error! No hemos encontrar el paciente asociado a la cita");
		}
		

}

$listaPacientes = $_pacientes->lista10Pacientes();
if(empty($listaPacientes)){
    $listaPacientes = array();
}

?>



		<!-- Content page -->
		<div class="container-fluid">
			<div class="page-header" style="padding-bottom: 0px!important; margin: 0px 0 0px !important;">
			  <h1 class="text-titles"> Agenda <small></small></h1>
			</div>
		</div>
		<div class="full-box text-center" style="padding: 30px 10px;">
					   <div id='calendar'>
					  
					   </div>
		</div>
<?php
echo "<script type='text/javascript' src='js/calendario_es.js'></script>";
echo $_template->cerrar();
?>



		<!-- Modal Crear Cita -->
		<div class="modal modal-md" tabindex="-1" role="dialog" id="crear">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h3 class="modal-title">Crear nueva cita </h3>
					</div>
					<form method="POST">
						<div class="modal-body">
													
							<div class="form-group">
								<div class="col-sm-4">
									<label for="txtfecha" style="color:#009688">Fecha</label>
									<input type="date" class="form-control" id="txtfecha" name="txtfecha"  placeholder="Fecha">
								</div>
								<div class="col-sm-4">
									<label for="txthorainicio" style="color:#009688">Hora Inicio</label>
									<input type="time" class="form-control" id="txthorainicio" name="txthorainicio"  placeholder="Fecha">
								</div>
								<div class="col-sm-4">
									<label for="txthorafin" style="color:#009688">Hora Fin</label>
									<input type="time" class="form-control" id="txthorafin" name="txthorafin"  placeholder="Fecha">
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-12">
									<div class="input-group" style="width:100%">
										<label for="txtpaciente" style="color:#009688; margin-right:5px;">Paciente : </label>
										<input type="hidden" class="form-control" name="txtpacienteid" id="txtpacienteid" >
										<label   name="txtpaciente" id="txtpaciente" ></label> 
										<div class="input-group-append">
											<button class="btn btn-primary" onclick="seleccionarPaciente()" style="background-color:#000; color:#FFF"  type="button" id="btnbuscarpaciente">Buscar paciente</button>
											<button class="btn btn-secondary" onclick="crearpaciente()" style="background-color:#022; color:#FFF" type="button" id="btncrearpaciente">Nuevo paciente</button>
										</div>
									</div>
								</div>
								
							</div>

							<div class="form-group">
								<div class="col-sm-12">
									<div class="input-group" style="width:100%">
										<label for="txtmotivo" style="color:#009688">Motivo de la cita</label>
										<textarea class="form-control" name="txtmotivo" id="txtmotivo" rows="3"></textarea>
									</div>
								</div>
							</div>

							<div class="form-group">
										<div class="col-sm-9">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="checktelefono" name="checktelefono" checked >
												<label for="txttratamiento" style="color:#009688">Enviar SMS confirmacion de cita</label>
												<a href="#!" style="color:black;" data-toggle="tooltip" data-placement="top" title="Se enviara SMS, si el paciente ha dado su consentimiento">
													<i class="zmdi zmdi-help-outline"></i>  
												</a>
											</div>
										</div>
							</div>

						</div>
						<div class="modal-footer">
							<div class="form-group">
								<div class="col-sm-12">
								<br><br>
									<button type="button" class="btn btn-danger" style="background-color:#dc3545; color:#FFF" data-dismiss="modal">Cancelar</button>
									<button type="submit" class="btn btn-primary" style="background-color:#17a2b8; color:#FFF" name="btnguardar" id="btnguardar">Guardar</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>

		<!-- Modal Crear paciente -->
		<div class="modal modal-md" tabindex="-1" role="dialog" id="crearpaciente">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h3 class="modal-title">Crear paciente </h3>
					</div>
					<form method="POST" name="frmguardarpaciente" id="frmguardarpaciente">
						<div class="modal-body">				
							<div class="form-group">
								<div class="col-sm-12">
									<label for="txtnombre" style="color:#009688">Nombre completo</label>
									<input type="text" class="form-control" id="txtnombre" name="txtnombre"  placeholder="Escriba el nombre del paciente">
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-12">
									<label for="txttelefono" style="color:#009688">Telefono</label>
									<input type="text" class="form-control" id="txttelefono" name="txttelefono"  placeholder="Escriba el telefono del paciente">
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-12">
									<label for="txtemail" style="color:#009688">Email</label>
									<input type="text" class="form-control" id="txtemail" name="txtemail"  placeholder="Escriba el email del paciente">
								</div>
							</div>


							<div class="form-group">
								<div class="col-sm-12">
									<label for="cbogenero" style="color:#009688">Genero</label>
									<select class="form-control" id="cbogenero" name="cbogenero">
										<option value="M">Masculino</option>
										<option value="F">Femenino</option>
									</select>
								</div>
							</div>


						</div>
						<div class="modal-footer">
						
							<div class="form-group">
								<div class="col-sm-12">
								<br><br><br>
									<button type="button" class="btn btn-danger" style="background-color:#dc3545; color:#FFF" data-dismiss="modal">Cancelar</button>
									<button type="submit" class="btn btn-primary" style="background-color:#17a2b8; color:#FFF" name="btnguardarpaciente" id="btnguardarpaciente">Guardar</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>

		<!-- Modal seleccionar paciente -->
		<div class="modal modal-md" tabindex="-1" role="dialog" id="seleccionarpaciente">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h3 class="modal-title">Seleccionar paciente </h3>
					</div>
						<div class="modal-body">	

								<div class="row">
									<form method="POST" id="frmbuscar">
										<div class="form-group">
													<div class="col-sm-5">
														<input type="text" name="txtbuscar" id="txtbuscar" class="form-control" placeholder="Nombre, Correo o Telefono">
													</div>
													<div class="col-sm-4">
														<button name="btnbuscar" id="btnbuscar" class="btn" style="color:#FFF; background-color:#17a2b8"> Buscar</button>
													</div>
										</div>
										<br><br>
									</form>		
								</div>
								<div class="table-responsive" id="tablapacientes">
									<table class="table table-striped table-bordered table-hover w-auto"  >
										<thead  class="">
											<tr class="bg-primary">
												<th>Nombre</th>
												<th>Correo</th>
												<th>Telefono</th>
											</tr>
										</thead>
										<tbody>
											<?php
												foreach ($listaPacientes as $key => $value) {
													$pacienteId = $value['PacienteId'];
													$nombrepaciente = $value["Nombre"];
													$correopaciente = $value["Correo"];
													$telefonopaciente = $value["Telefono"];

													echo "
														<tr data-id='$pacienteId' data-name='$nombrepaciente'>
															<td>$nombrepaciente</td>
															<td>$correopaciente</td>
															<td>$telefonopaciente</td>
														</tr>
													";
												}
											?>
										
										</tbody>
									</table>     
								</div> 
						</div>
						<div class="modal-footer">
							<br>
							<button type="button" class="btn btn-danger" style="background-color:#dc3545; color:#FFF" data-dismiss="modal">Cancelar</button>
						</div>
					
				</div>
			</div>
		</div>

		<!-- Modal modificar cita -->
		<div class="modal modal-md" tabindex="-1" role="dialog" id="editar">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h3 class="modal-title">Datos de la cita </h3>
					</div>
					<form method="POST">
						<div class="modal-body">
													
							<div class="form-group">
								<div class="col-sm-4">
									<label for="txtfecha"  style="color:#009688">Fecha</label>
									<input type="date" class="form-control" id="txtfecha_editar" name="txtfecha_editar"  placeholder="Fecha">
								</div>
								<div class="col-sm-4">
									<label for="txthorainicio"  style="color:#009688">Hora Inicio</label>
									<input type="time" class="form-control" id="txthorainicio_editar" name="txthorainicio_editar"  placeholder="Fecha">
								</div>
								<div class="col-sm-4">
									<label for="txthorafin"  style="color:#009688">Hora Fin</label>
									<input type="time" class="form-control" id="txthorafin_editar" name="txthorafin_editar"  placeholder="Fecha">
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-12">
									<div class="input-group" style="width:100%">
										<label for="txtpaciente_editar"  style="color:#009688">Paciente</label>
										<input type="hidden" class="form-control" name="txtcodigo_cita" id="txtcodigo_cita" >
										<input type="text" class="form-control" name="txtpaciente_editar" id="txtpaciente_editar" disabled>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-6">
									<div class="input-group" style="width:100%">
										<label for="txtpaciente_editar"  style="color:#009688">Telefono</label>
										<input type="text" class="form-control" name="txttelefono_editar" id="txttelefono_editar" disabled>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="input-group" style="width:100%">
										<label for="txtpaciente_editar"  style="color:#009688">Correo</label>
										<input type="text" class="form-control" name="txtcorreo_editar" id="txtcorreo_editar" disabled>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-12">
									<div class="input-group" style="width:100%">
										<label for="txtmotivo" style="color:#009688">Motivo de la cita</label>
										<textarea class="form-control" name="txtmotivo_editar" id="txtmotivo_editar" rows="3"></textarea>
									</div>
								</div>
							</div>


						</div>
						<div class="modal-footer">
							<div class="form-group">
								<div class="col-sm-12">
								<br><br>
								    <button type="button" class="btn btn-danger" style="background-color:#e30052; color:#FFF;  float:left !important; display:none;" name="btneliminar_editar" id="btneliminar_editar">Eliminar</button>
									<button type="button" class="btn btn-danger" style="background-color:#dc3545; color:#FFF;" data-dismiss="modal">Salir</button>
									<button type="submit" class="btn btn-primary" style="background-color:#17a2b8; color:#FFF" name="btnguardar_editar" id="btnguardar_editar">Editar</button>
									<button type="submit" class="btn btn-primary" style="background-color:#B695C0; color:#FFF" name="btnconsulta" id="btnconsulta">Ir a la Historia</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div> 


