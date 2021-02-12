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


$usuarioId = $_GET['id'];
$correo = $_usuarios->verCorreo($usuarioId);

if(isset($_POST['btnguarda'])){
    $contra = $_POST['txtpassword'];
    $resp = $_usuarios->cambiarContraseña($usuarioId,$contra);
    if($resp){
        echo $_alertas->success("Contraseña Actualizada");
    }else{
        echo $_alertas->error("No hemos podido actualizar los datos");
    }
}


$listaRoles = $_usuarios->listaRoles();
if(empty($listaRoles)){
    $listaRoles = array();
}


?>


<div class="container">

                    <form method="POST" autocomplete="off"> 
				
                                         <div class="form-group">
                                            <div class="col-sm-12">
                                                <div class="col-sm-6">
                                                    <label for="txtcorreo" style="color:#009688">Correo Electronico</label>
                                                    <input type="text" class="form-control" id="txtcorreo" name="txtcorreo" value="<?=$correo?>"  placeholder="Escriba el correo electronico" disabled>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="col-sm-3">
                                                    <label for="txtpassword" style="color:#009688">Contraseña</label>
                                                    <input type="password" class="form-control" id="txtpassword" name="txtpassword"  placeholder="Escriba la contraseña" autocomplete="off">
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="txtpasssword2" style="color:#009688">Repetir Contraseña</label>
                                                    <input type="password" class="form-control" id="txtpasssword2" name="txtpasssword2"  placeholder="Repita la contraseña" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
					
							<div class="form-group">
								<div class="col-sm-12">
                                <br>
									<a href="lista_usuarios.php" class="btn btn-danger" style="background-color:#dc3545; color:#FFF;" data-dismiss="modal">Salir</a>
                                    <button type="submit" class="btn btn-primary" style="background-color:#17a2b8; color:#FFF" name="btnguarda" id="btnguarda">Guardar</button>
								</div>
							</div>
						
					</form>



</div>


<?php
echo "<script type='text/javascript' src='js/lista_usuarios.js'></script>";
echo $_template->cerrar();
?>