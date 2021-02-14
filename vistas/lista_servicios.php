<?php
require_once "../autoload/autoload.php";
session_start();
$_template = new template;
$_servicios = new servicios;
$_alertas = new alertas;
if(!isset($_SESSION['Parrot']['Usuario'])){
	header("Location: ../index.php");
	die();
}


echo $_template->abrir();


if(isset($_POST['btnguardar'])){
	$nombre= $_POST['txtnombre'];
	$categoriaId = $_POST['cbocategorias'];
	$precio = $_POST['txtprecio'];
	$iva = $_POST['txtiva'];
    $resp = $_servicios->guardar($nombre,$categoriaId,$precio,$iva);
    if($resp){
        echo $_alertas->success("¡Correcto! Servicio creado");
    }else{
        echo $_alertas->success("¡Error! No hemos podido crear el servicio");
    }

}

if(isset($_POST['btnguardar_editar'])){
    $nombre = $_POST['txtnombre_editar'];
	$estado = $_POST['cboestado_editar'];
	$categoriaId = $_POST['cbocategorias_editar'];
	$precio = $_POST['txtprecio_editar'];
	$iva = $_POST['txtiva_editar'];
    $servicioid = $_POST['txtservicioid_editar'];
    $resp = $_servicios->editar($nombre,$estado,$servicioid,$precio,$iva);
    if($resp){
       echo $_alertas->success("¡Correcto! Datos actualizados");
    }else{
       echo $_alertas->error("No hemos actualizado los datos");
    }
}

$listaServicios = $_servicios->listaServiciosCompleta();
$listaCategorias = $_servicios->obtenerCategorias();

?>
<style>
    .table-hover thead tr:hover th, .table-hover tbody tr:hover td {
        background-color: #D2EFEE;
    }
</style>

        <!-- Content page -->
        <div class="container-fluid">
			<div class="page-header" style="padding-bottom: 0px!important; margin: 0px 0 0px !important;">
			  <h1 class="text-titles"> Lita de Servicios <small></small></h1>
			</div>
		</div>
        <div class="container">
            <button type="submit" class="btn btn-primary" style="background-color:#009688; color:#FFF" name="btnnuevo" id="btnnuevo">Crear nuevo servicio</button>
        </div>

        <div class="full-box" style="padding: 30px 10px;">
                <div class="container">
                        <div class="table-responsive" id="tablapacientes">
                            <table class="table tables table-striped table-bordered table-hover w-auto"  >
                                <thead  class="">
                                    <tr class="bg-primary">
                                        <th>Servicio</th>
                                        <th>Precio</th>
                                        <th>IVA</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        foreach ($listaServicios as $key => $value) {
                                            $servicioId = $value['ServicioId'];
                                            $nombre = $value["Nombre"];
											$estado = $value["Estado"];
											$precio = $value['Precio'];
											$iva = $value["IVA"];
                                            $categoria = $value["CategoriaId"];
                                            echo "
                                                <tr data-id='$servicioId' data-nombre='$nombre' data-estado='$estado' data-categoria='$categoria'  data-precio='$precio'  data-iva='$iva'>
													<td>$nombre</td>
													<td style='text-align:right'>$precio €</td>
													<td>$iva %</td>
                                                    <td>$estado</td>
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
echo "<script type='text/javascript' src='js/lista_servicios.js'></script>";
echo $_template->cerrar();
?>

 		<!-- Modal crear servicio -->
         <div class="modal modal-md" tabindex="-1" role="dialog" id="crear">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h3 class="modal-title">Crear nuevo servicio </h3>
					</div>
					<form method="POST" name="frmcrearservicio" id="frmcrearservicio">
						<div class="modal-body">				
							<div class="form-group">
								<div class="col-sm-9">
									<label for="txtnombre" style="color:#009688">Nombre del servicio</label>
									<input type="text" class="form-control" id="txtnombre" name="txtnombre"  placeholder="Escriba el nombre del servicio">
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-9">
									<label for="cboestado" style="color:#009688">Categoria</label>
									<select class="form-control" id="cbocategorias" name="cbocategorias">
										<option value='0' disabled selected>-Seleccione una categoria-</option>
									<?php
										foreach ($listaCategorias as $key => $value) {
											$categoriaId = $value['CategoriaId'];
											$categoriaNombre = $value['Nombre'];
											echo "
												<option value='$categoriaId'>$categoriaNombre</option>
											";
											
										}
									
									?>
											
									</select>
								</div>
							</div>
							<div class="form-group">
								<div class="form-group">
									<div class="col-sm-4">
										<label for="txtnombre" style="color:#009688">Precio(€)</label>
										<input type="text" class="form-control" id="txtprecio" name="txtprecio"  placeholder="0.00">
										
									</div>
									<div class="col-sm-4">
										<label for="txtnombre" style="color:#009688">IVA(%)</label>
										<input type="text" class="form-control" id="txtiva" name="txtiva"  placeholder="0" value="0">
									</div>
								</div>
							</div>

						</div>
						<div class="modal-footer">
						
							<div class="form-group">
								<div class="col-sm-12">
								<br><br><br>
									<button type="button" class="btn btn-danger" style="background-color:#dc3545; color:#FFF" data-dismiss="modal">Cancelar</button>
									<button type="submit" class="btn btn-primary" style="background-color:#17a2b8; color:#FFF" name="btnguardar" id="btnguardar">Guardar</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>

        <!-- Modal editar servicio -->
        <div class="modal modal-md" tabindex="-1" role="dialog" id="editar">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h3 class="modal-title">Editar servicio </h3>
					</div>
					<form method="POST" name="frmcrearservicio" id="frmcrearservicio">
						<div class="modal-body">				
							<div class="form-group">
								<div class="col-sm-12">
									<label for="txtnombre_editar" style="color:#009688">Nombre del servicio</label>
                                    <input type="hidden" name="txtservicioid_editar" id="txtservicioid_editar">
									<input type="text" class="form-control" id="txtnombre_editar" name="txtnombre_editar"  placeholder="Escriba el nombre del servicio">
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-9">
									<label for="cboestado" style="color:#009688">Categoria</label>
									<select class="form-control" id="cbocategorias_editar" name="cbocategorias_editar">
										<option value='0' disabled selected>-Seleccione una categoria-</option>
									<?php
										foreach ($listaCategorias as $key => $value) {
											$categoriaId = $value['CategoriaId'];
											$categoriaNombre = $value['Nombre'];
											echo "
												<option value='$categoriaId'>$categoriaNombre</option>
											";
											
										}
									
									?>
											
									</select>
								</div>
							</div>
							<div class="form-group">
								<div class="form-group">
									<div class="col-sm-4">
										<label for="txtnombre" style="color:#009688">Precio(€)</label>
										<input type="text" class="form-control" id="txtprecio_editar" name="txtprecio_editar"  placeholder="0.00">
									</div>
									<div class="col-sm-4">
										<label for="txtnombre" style="color:#009688">IVA(%)</label>
										<input type="text" class="form-control" id="txtiva_editar" name="txtiva_editar"  placeholder="0" value="0">
									</div>
								</div>
							</div>
                            <div class="form-group">
								<div class="col-sm-12">
									<label for="cboestado" style="color:#009688">Estado</label>
									<select class="form-control" id="cboestado_editar" name="cboestado_editar">
												<option value='Activo'>Activo</option>
												<option value='Inactivo'>Inactivo</option>
									</select>
								</div>
							</div>

						</div>
						<div class="modal-footer">
						
							<div class="form-group">
								<div class="col-sm-12">
								<br><br><br>
									<button type="button" class="btn btn-danger" style="background-color:#dc3545; color:#FFF" data-dismiss="modal">Cancelar</button>
									<button type="submit" class="btn btn-primary" style="background-color:#17a2b8; color:#FFF" name="btnguardar_editar" id="btnguardar_editar">Guardar</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>