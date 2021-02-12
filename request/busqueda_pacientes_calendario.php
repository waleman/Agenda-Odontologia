<?php
require_once '../clases/pacientes.class.php';
$_pacientes = new pacientes;

$campo = $_POST['txtbuscar'];

$listaPacientes = $_pacientes->buscarPacientes($campo);
if(empty($listaPacientes)){
    $listaPacientes = array();
}

?>

                    <table class="table table-striped table-bordered table-hover"  >
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
