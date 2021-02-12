<?php
    require_once "../autoload/autoload.php";
    session_start();
    $_template = new template;
    if(!isset($_SESSION['Parrot']['Usuario'])){
        header("Location: ../index.php");
        die();
    }

    echo $_template->abrirEspecial();
    echo "
        <link href='../theme/odontograma/css/odontograma.css' rel='stylesheet'>
        <script src='../theme/odontograma/js/odontCanvas/core/engine.js' type='text/javascript'></script>
      
    ";
?>

<nav class="navbar navbar-dark bg-primary">
  <!-- Navbar content -->
</nav>


<div class="container-fluid"  >
    <div class="row">
            <div class="col-sm-6 col-md-6" oncontextmenu="return false;">
                <h3>Odontograma</h3>
                <canvas id="canvas" width="648" height="420"></canvas>
            </div>
          
            <div class="col-sm-2  col-md-2" >
              <h4>Categorias</h4>
                <div class="card" id="btnobturacion" >
                    <div class="card-body">
                        <img src="../public/imagenes/fractura.svg" alt="" width="20px">
                        <span id="lblobturacion">Obturacion</span>
                    </div>
                </div>
                <div class="card" id="btnextraccion">
                    <div class="card-body" id="extraccion">
                        <img src="../public/imagenes/extraccion.svg" alt="" width="20px">
                        Extraccion 
                    </div>
                </div>
                <div class="card" id="btnextraccionraiz">
                    <div class="card-body" id="extraccion">
                        <img src="../public/imagenes/extraccionraiz.svg" alt="" width="20px">
                        Extraccion Raiz
                    </div>
                </div>
                <div class="card" id="btncorona" >
                    <div class="card-body">
                        <img src="../public/imagenes/corona.svg" alt="" width="20px">
                        Corona 
                    </div>
                </div>
                <div class="card" id="btnimplante" >
                    <div class="card-body">
                        <img src="../public/imagenes/implante.svg" alt="" width="20px">
                        Implante 
                    </div>
                </div>
                <div class="card" id="btnendodoncia" >
                    <div class="card-body">
                        <img src="../public/imagenes/endodoncia.svg" alt="" width="20px">
                        Endodoncia 
                    </div>
                </div>
                <div class="card" id="btnmunon" >
                    <div class="card-body">
                        <img src="../public/imagenes/puente.svg" alt="" width="20px">
                        Muñon
                    </div>
                </div>
                <div class="card" id="btnlimpieza" >
                    <div class="card-body">
                        <img src="../public/imagenes/limpieza.svg" alt="" width="20px">
                        Limpieza 
                    </div>
                </div>
                <div class="card" id="btnotro" >
                    <div class="card-body">
                        <img src="../public/imagenes/otro.svg" alt="" width="20px">
                        Otro 
                    </div>
                </div>
            </div>
              <!-- inicio panel -->
              <div class="col-sm-4 col-md-4">  
                  <h4>Tratamientos</h4>
                   <ul class="list-group" id="servicios"></ul>                 
             </div>
             <!-- fin panel -->
    </div>
    <!-- Tabla de tratamientos -->
    <div class="row contraste" >
        <div class="col-sm-9 col-md-9 " id="tablatratamientos">
            <h3> Presupuesto </h3>
            <table id="contenido" class="table table-outline table-striped table-hover" >
                <thead  >
                    <tr class="bg-primary">
                        <th scope="col">Acciones</th>
                        <th scope="col">Tratamiento</th>
                        <th scope="col">Pieza</th>
                        <th scope="col">Cara</th>
                        <th scope="col">Precio</th>
                        <th scope="col">IVA</th>
                        <th scope="col">Total</th>
                    </tr>
                </thead>
                <tbody  >               
                </tbody>
            </table>
            <br><br><br>
        </div>
        <div class="col-sm-2 col-md-2 "  >
            <div class="">         
               <h3>Acciones</h3>
               <button type="button" class="btn btn-primary btn-lg btn-block" style="background-color:#17a2b8; color:#FFF">Guardar</button>
               <button type="button" class="btn btn-primary btn-lg btn-block" style="background-color:#28a745; color:#FFF">Guardar e Imprimir</button>
               <button type="button" class="btn btn-primary btn-lg btn-block" style="background-color:#dc3545; color:#FFF">Salir</button>
            </div>
        </div>
    </div>
</div>


    <!-- Modal agregar tratamiento -->
	<div class="modal modal-md" tabindex="-1" role="dialog" id="modaltramiento">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h3 class="modal-title">Tratamiento </h3>
					</div>
					<form method="POST">
                        <div class="modal-body">								
                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <div class="col-sm-4">
                                            <label for="txtpieza"  style="color:#009688">Diente</label>
                                            <input type="text" class="form-control" id="txtpieza" name="txtpieza"  placeholder="Diente">
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="txtcara"  style="color:#009688">Cara</label>
                                            <input type="text" class="form-control" id="txtcara" name="txtcara"  placeholder="Cara">
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="txttratamiento"  style="color:#009688">Categoria</label>
                                            <input type="text" class="form-control" id="txttratamiento" name="txttratamiento"  placeholder="categoria">
                                        </div>
                                        <div class="col-sm-12">
                                            <label for="txtservicio"  style="color:#009688">Servicio</label>
                                            <input type="text" class="form-control" id="txtservicio" name="txtservicio"  placeholder="categoria">
                                        </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <div class="input-group" style="width:100%">
                                                    <label for="txtobservacion" style="color:#009688">Observacion</label>
                                                    <textarea class="form-control" name="txtobservacion" id="txtobservacion" rows="4"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                              
                            </div>
							
						</div>
                            <div class="modal-footer">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                  
                                        <!-- <button type="button" class="btn btn-danger" style="background-color:#dc3545; color:#FFF;" data-dismiss="modal" name="btnsalirtratamiento" id="btnsalirtratamiento">Salir</button> -->
                                        <button type="submit" class="btn btn-primary" style="background-color:#17a2b8; color:#FFF" name="btnguardartratamiento" id="btnguardartratamiento">Guardar</button>
                                    </div>
                                </div>
                            </div>
					</form>
				</div>
			</div>
    </div> 
    
    <!-- Modal Editar  tratamiento -->
	<div class="modal modal-md" tabindex="-1" role="dialog" id="modaleditartramiento">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h3 class="modal-title">Tratamiento </h3>
					</div>
					<form method="POST">
                        <div class="modal-body">								
                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <div class="col-sm-4">
                                            <label for="txtpieza"  style="color:#009688">Diente</label>
                                            <input type="text" class="form-control" id="txteditarpieza" name="txteditarpieza"  placeholder="Diente">
                                            <input type="hidden" class="form-control" id="txtidepresupuesto" name="txtidepresupuesto"  placeholder="">
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="txtcara"  style="color:#009688">Cara</label>
                                            <input type="text" class="form-control" id="txteditarcara" name="txteditarcara"  placeholder="Cara">
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="txttratamiento"  style="color:#009688">Categoria</label>
                                            <input type="text" class="form-control" id="txteditartratamiento" name="txteditartratamiento"  placeholder="categoria">
                                        </div>
                                        <div class="col-sm-12">
                                            <label for="txtservicio"  style="color:#009688">Servicio</label>
                                            <input type="text" class="form-control" id="txteditarservicio" name="txteditarservicio"  placeholder="categoria">
                                        </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <div class="input-group" style="width:100%">
                                                    <label for="txtobservacion" style="color:#009688">Observacion</label>
                                                    <textarea class="form-control" name="txteditarobservacion" id="txteditarobservacion" rows="4"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                              
                            </div>
							
						</div>
                            <div class="modal-footer">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <button type="button" class="btn btn-danger" style="background-color:#dc3545; color:#FFF;" data-dismiss="modal" >Cerrar</button>
                                        <button type="button" class="btn btn-primary" style="background-color:#17a2b8; color:#FFF" name="btneditartratamiento" id="btneditartratamiento">Editar</button>
                                    </div>
                                </div>
                            </div>
					</form>
				</div>
			</div>
	</div> 

    <!-- Modal Eliminar  tratamiento -->
	<div class="modal modal-md" tabindex="-1" role="dialog" id="modaleliminartramiento">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h3 class="modal-title">¿Esta seguro que desa eliminar este tratamiento ? </h3>
					</div>
					<form method="POST">
                            <input type="hidden" id="txtideliminar">
                            <div class="modal-footer">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <button type="button" class="btn btn-danger" style="background-color:#dc3545; color:#FFF;" data-dismiss="modal" >NO</button>
                                        <button type="button" class="btn btn-primary" style="background-color:#17a2b8; color:#FFF" name="btneliminartratamiento" id="btneliminartratamiento">SI</button>
                                    </div>
                                </div>
                            </div>
					</form>
				</div>
			</div>
	</div> 






<?php
echo "  <script src='js/odontograma.js' type='text/javascript'></script>";
echo $_template->cerrarEspecial();
?>

