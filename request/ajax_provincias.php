<?php
require_once '../clases/pacientes.class.php';
$_pacientes = new pacientes;

$paisId = $_GET['id'];
$ListaProvincias = $_pacientes->obtenerProvincias($paisId);

echo "  <label for='cbogenero' style='color:#009688'>Provincia</label>
        <select class='form-control' id='cboprovincia' name='cboprovincia'>
            <option value='0' selected disabled>- Seleccione Provincia -</option>";                                  
            foreach ($ListaProvincias as $key => $value) {
                $provinciaId= $value['ProvinciaId'];
                $provinciaNombre = $value['Nombre'];
                    echo "
                    <option value='$provinciaId' >$provinciaNombre</option>
                    ";
                
            }
echo " </select>"                                        

?>