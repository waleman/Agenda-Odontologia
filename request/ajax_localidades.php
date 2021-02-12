<?php
require_once '../clases/pacientes.class.php';
$_pacientes = new pacientes;

$provinciaId = $_GET['id'];
$ListaPoblaciones = $_pacientes->obtenerPoblaciones($provinciaId);

echo "  <label for='cbopoblacion' style='color:#009688'>Provincia</label>
        <select class='form-control' id='cbopoblacion' name='cbopoblacion'>
            <option value='0' selected disabled>- Seleccione Provincia -</option>";                                  
            foreach ($ListaPoblaciones as $key => $value) {
                $poblacionId= $value['LocalidadId'];
                $poblacionNombre = $value['Nombre'];
                    echo "
                    <option value='$poblacionId' >$poblacionNombre</option>
                    ";
                
            }
echo " </select>"                                        

?>