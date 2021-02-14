<?php
require_once "../autoload/autoload.php";
session_start();
$_template = new template;
$_usuarios = new usuarios;
$_alertas = new alertas;
if(!isset($_SESSION['Parrot']['Usuario'])){
	header("Location: ../index.php");
	die();
}



echo $_template->abrir();



if(isset($_POST['btnguarda'])){
    $usuario = $_POST['txtcorreo'];
    $password  = $_POST['txtpassword'];
    $rol = $_POST['cborol'];
    $verificar = $_usuarios->verificarEmail($usuario);
    if(!$verificar){
        $resp = $_usuarios->guardar($usuario,$password,$rol);
        if($resp){
            echo $_alertas->success("Usuario creado exitosamente");
        }else{
            echo $_alertas->error("No hemos podido crear el usuario");
        }
    }else{
        echo $_alertas->error("El correo ya esta en uso");
    }
}


$listausuarios = $_usuarios->listaUsuarios();
if(empty($listausuarios)){
    $listausuarios = array();
}

$listaRoles = $_usuarios->listaRoles();
if(empty($listaRoles)){
    $listaRoles = array();
}
?>


       <!-- Content page -->
       <div class="container-fluid">
			<div class="page-header" style="padding-bottom: 0px!important; margin: 0px 0 0px !important;">
			  <h1 class="text-titles"> Lita de usuarios <small></small></h1>
			</div>
		</div>
        <div class="container">
            <button type="submit" class="btn btn-primary" style="background-color:#009688; color:#FFF" name="btnnuevo" id="btnnuevo">Crear nuevo usuario</button>
        </div>

        <div class="full-box" style="padding: 30px 10px;">
                <div class="container">
                        <div class="table-responsive" id="tablapacientes">
                            <table class="table tables table-striped table-bordered table-hover w-auto"  >
                                <thead  class="">
                                    <tr class="bg-primary">
                                        <th>Servicio</th>
                                        <th>Rol</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        foreach ($listausuarios as $key => $value) {
                                            $usuarioId = $value['UsuarioId'];
                                            $nombre = $value["Usuario"];
                                            $rol = $value["Rol"];
                                            $estado = $value["Estado"];
                                            echo "
                                                <tr data-id='$usuarioId'>
                                                    <td>$nombre</td>
                                                    <td>$rol</td>
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
echo "<script type='text/javascript' src='js/lista_usuarios.js'></script>";
echo $_template->cerrar();
?>



<!-- Modal historianuevo usuario -->
<div class="modal modal-md" tabindex="-1" role="dialog" id="nuevousuario">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h3 class="modal-title">Nuevo Usuario </h3>
					</div>
					<form method="POST">
						<div class="modal-body">
								<!-- historial -->	
                                    <from method="POST">
                                         <div class="form-group">
                                            <div class="col-sm-12">
                                                <label for="txtcorreo" style="color:#009688">Correo Electronico</label>
                                                <input type="text" class="form-control" id="txtcorreo" name="txtcorreo"  placeholder="Escriba el correo electronico">
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="txtpassword" style="color:#009688">Contraseña</label>
                                                <input type="password" class="form-control" id="txtpassword" name="txtpassword"  placeholder="Escriba la contraseña">
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="txtpasssword2" style="color:#009688">Repetir Contraseña</label>
                                                <input type="password" class="form-control" id="txtpasssword2" name="txtpasssword2"  placeholder="Repita la contraseña">
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label for="cborol" style="color:#009688">Rol</label>
                                                    <select class="form-control" name="cborol" id="cborol">
                                                    <option value='0'> --- Seleccione uno --- </option>
                                                        <?php 
                                                            foreach ($listaRoles as $key => $value) {
                                                                $rolid = $value['RolId'];
                                                                $rolNombre = $value['Nombre'];
                                                                    echo "
                                                                        <option value='$rolid'>$rolNombre</option>
                                                                    ";  
                                                            }
                                                        ?>  
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    
                     </from>
						</div>
						<div class="modal-footer">
							<div class="form-group">
								<div class="col-sm-12">
									<button type="button" class="btn btn-danger" style="background-color:#dc3545; color:#FFF;" data-dismiss="modal">Salir</button>
                                    <button type="submit" class="btn btn-primary" style="background-color:#17a2b8; color:#FFF" name="btnguarda" id="btnguarda">Guardar</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div> 
