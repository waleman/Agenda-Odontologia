<?php
require_once "../autoload/autoload.php";
session_start();
$_template = new template;
$_pacientes = new pacientes;
if(!isset($_SESSION['Parrot']['Usuario'])){
	header("Location: ../index.php");
	die();
}

echo $_template->abrir();


	/* js y css adicional */
	echo "
        <link href='../theme/datatable/datatables.min.css' rel='stylesheet' />
        <script src='../theme/datatable/datatables.min.js'></script> 
     ";
     
$listaPacientes = $_pacientes-> listaPacientes();
if(empty($listaPacientes)){
    $listaPacientes = array();
}

?>
<style>
    .table-hover thead tr:hover th, .table-hover tbody tr:hover td {
        background-color: #D2EFEE;
    }
</style>

		<!-- Content page -->
		<div class="container-fluid">
			<div class="page-header" style="padding-bottom: 0px!important; margin: 0px 0 0px !important;">
			  <h1 class="text-titles"> Lita de pacientes <small></small></h1>
			</div>
		</div>
        <div class="container">
            <button type="submit" class="btn btn-primary" style="background-color:#009688; color:#FFF" name="btnnuevo" id="btnnuevo">Crear nuevo paciente</button>
        </div>
        <div class="full-box" style="padding: 30px 10px;">
                <div class="container" >    
                    <form method="POST" id="frmbuscar">
                        <div class="form-group">
                                    <div class="col-sm-5">
                                        <input type="text" name="txtbuscar" id="txtbuscar" class="form-control" placeholder="Nombre, Correo o Telefono">
                                    </div>
                                    <div class="col-sm-4">
                                        <button name="btnbuscar" id="btnbuscar" class="btn" style="color:#FFF; background-color:#17a2b8; margin-top: -2px"> Buscar</button>
                                    </div>
                        </div>
                        <br><br>
                    </form>
                </div>
                <div class="container">
                        <div class="table-responsive" id="tablapacientes">
                            <table class="table tables table-striped table-bordered table-hover w-auto"  >
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
                                                <tr data-href='detalle_paciente.php?pacienteId=$pacienteId'>
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


        </div>


<?php
echo "<script type='text/javascript' src='js/lista_pacientes.js'></script>";
echo $_template->cerrar();
?>
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