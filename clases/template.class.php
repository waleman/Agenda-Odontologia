<?php 
require_once 'clinica.class.php';
require_once 'alertas.class.php';

class template{

 
    public function abrir($titulo = "Parrot | Sistema de gestion"){
        $_clinica = new clinica;
        $nombreClinica = $_clinica->nombreClinica();
        $usuario = $_SESSION['Parrot']['Usuario'];
        $html = "
        <!DOCTYPE html>
            <html lang='es'>
            <head>
                <title>$titulo</title>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0'>
                <!--====== Scripts -->
                <script src='../theme/js/jquery-3.1.1.min.js'></script>
                <script src='../theme/js/bootstrap.min.js'></script>
                <script src='../theme/js/material.min.js'></script>
                <script src='../theme/js/ripples.min.js'></script>
                <script src='../theme/js/jquery.mCustomScrollbar.concat.min.js'></script>
                <script src='../theme/js/main.js'></script>
                <script src='../theme/alert/alertify.min.js'></script>
                <script src='../theme/js/tablas.js'></script>
                <!-- <script src='../theme/js/afk.js'></script> -->
              
              
                <link rel='stylesheet' href='../theme/css/main.css'>
                <link rel='stylesheet' href='../theme/css/fieldset.css'>
                <link rel='stylesheet' href='../theme/css/tablas.css'>

                <link rel='stylesheet' href='../theme/alert/css/alertify.min.css'>
                <link rel='stylesheet' href='../theme/alert/css/themes/bootstrap.min.css'>

            </head>
            <body>
            <!-- SideBar -->
            <section class='full-box cover dashboard-sideBar'>
                <div class='full-box dashboard-sideBar-bg btn-menu-dashboard'></div>
                <div class='full-box dashboard-sideBar-ct'>
                    <!--SideBar Title -->
                    <div class='full-box text-uppercase text-center text-titles dashboard-sideBar-title'>
                    $nombreClinica <i class='zmdi zmdi-close btn-menu-dashboard visible-xs'></i>
                    </div>
                    <!-- SideBar User info -->
                    <div class='full-box dashboard-sideBar-UserInfo'>
                        <figure class='full-box'>
                            <img src='../public/imagenes/usuario.png' alt='UserIcon'>
                            <figcaption class='text-center text-titles'> $usuario </figcaption>
                        </figure>
                        <ul class='full-box list-unstyled text-center'>
                            <li>
                                <a href='#' class='btn-dialog-config'>
                                    <i class='zmdi zmdi-settings'></i>
                                </a>
                            </li>

                        </ul>
                    </div>
                    <!-- SideBar Menu -->
                    <ul class='list-unstyled full-box dashboard-sideBar-Menu'>
                        <li>
                            <a href='calendario'>
                                <i class='zmdi zmdi-view-dashboard zmdi-hc-fw'></i> Agenda </a>
                        </li>
                        <li>
                            <a href='lista_pacientes.php'>
                                 <i class='zmdi zmdi-male-female zmdi-hc-fw'></i> Lista de pacientes
                            </a>     
                        </li>
                        <li>
                            <a href='#!' class='btn-sideBar-SubMenu'>
                                <i class='zmdi zmdi-network-setting zmdi-hc-fw'></i> Configuracion  <i class='zmdi zmdi-caret-down pull-right'></i>
                            </a>
                            <ul class='list-unstyled full-box'>
                                <li>
                                    <a href='lista_servicios.php'><i class='zmdi zmdi-gamepad zmdi-hc-fw'></i> Servicios</a>
                                </li>
                                <li>
                                    <a href='lista_usuarios.php'><i class='zmdi zmdi-account zmdi-hc-fw'></i> Usuarios</a>
                                </li>
                                <li>
                                    <a href='detalle_clinica.php'><i class='zmdi zmdi-hospital zmdi-hc-fw'></i>Clinica</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </section>

            <!-- Content page-->
            <section class='full-box dashboard-contentPage'>
                <!-- NavBar -->
                <nav class='full-box dashboard-Navbar'>
                    <ul class='full-box list-unstyled text-right'>
                        <li class='pull-left'>
                            <a href='#!' class='btn-menu-dashboard'><i class='zmdi zmdi-more-vert'></i></a>
                        </li>
                        <li>
                         <a href='../index.php' class='btn-exit-system'>
                          <i class='zmdi zmdi-power'></i>
                         </a>
                        </li>
                        <li>
                            <a href='#!' class='btn-modal-help'>
                                <i class='zmdi zmdi-help-outline'></i>
                            </a>
                        </li>
                    </ul>
                </nav>
        ";

        return $html;

    }

    public function cerrar(){
        
        $_clinica = new clinica;
        $_alertas = new alertas;
     

        if(isset($_POST['txtguardarcalendario'])){
            $horaInicio = strtotime($_POST['txtCalendarioInicio']);
            $horaFin = strtotime($_POST['txtCalendarioFin']);
            if( $horaInicio > $horaFin ) {
                echo $_alertas->error("Error : La hora de inicio debe ser menor a la hora de fin");
            } else {
                $horaInicio = $_POST['txtCalendarioInicio'];
                $horaFin = $_POST['txtCalendarioFin'];
                $duracion = $_POST['txtduracion'];
                if($duracion <= 5 ){
                    $duracion = 5;
                }
                if(isset($_POST['checkLunes'])){ $lunes = 1; }else{ $lunes = 0; }
                if(isset($_POST['checkMartes'])){ $martes = 1; }else{ $martes =0;}
                if(isset($_POST['checkMiercoles'])){ $miercoles = 1; }else{ $miercoles = 0; }
                if(isset($_POST['checkJueves'])){ $jueves = 1;}else{ $jueves = 0; }
                if(isset($_POST['checkViernes'] )){ $viernes = 1; }else{ $viernes = 0;}
                if(isset($_POST['checkSabado'])){ $sabado = 1; }else{ $sabado = 0; }
                if(isset($_POST['checkDomingo'])){ $domingo = 1;}else{ $domingo =0; }
              
                $respuesta = $_clinica->editarHorarios($horaInicio,$horaFin,$duracion,$lunes,$martes,$miercoles,$jueves,$viernes,$sabado,$domingo);
                if($respuesta){
                    echo $_alertas->success("Hecho: Horario actualizado");
                }else{
                    echo $_alertas->error("Error: No hay datos para modificar");
                }
            } 

        }

        $datosClinica = $_clinica->datosCalendarioClinica();
        $horaInicio = $datosClinica['HoraInicio'];
        $duracion = $datosClinica['Duracion'];
        $dias = array();
        $horaFin = $datosClinica['HoraFin'];
        $lunes = $datosClinica['Lunes'];
        if($lunes){ $lunes = "checked"; }else{ ""; $dias[] = 1; }
        $martes = $datosClinica['Martes'];
        if($martes){ $martes = "checked"; }else{ ""; $dias[] = 2; }
        $miercoles = $datosClinica['Miercoles'];
        if($miercoles){ $miercoles = "checked"; }else{ ""; $dias[] = 3; }
        $jueves = $datosClinica['Jueves'];
        if($jueves){ $jueves = "checked"; }else{ ""; $dias[] = 4; }
        $viernes = $datosClinica['Viernes'];
        if($viernes){ $viernes = "checked"; }else{ ""; $dias[] = 5; }
        $sabado = $datosClinica['Sabado'];
        if($sabado){ $sabado = "checked"; }else{ ""; $dias[] = 6; }
        $domingo = $datosClinica['Domingo'];
        if($domingo){ $domingo = "checked"; }else{ ""; $dias[] = 0; }

        $dias = implode( ',', $dias );

        $html = "

        <script>
            var diasNoMostrar = [$dias];
            var duracion = $duracion ;
           
        </script>

        </section>

            <div class='modal fade' tabindex='-1' role='dialog' id='Dialog-Help'>
                <div class='modal-dialog' role='document'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                            <h4 class='modal-title'>Ayuda</h4>
                        </div>
                        <div class='modal-body'>
                            <p>
                               Para mas ayuda porfavor pongase en contacto con el desarollador
                            </p>
                        </div>
                        <div class='modal-footer'>
                            <button type='button' class='btn btn-primary btn-raised' data-dismiss='modal'><i class='zmdi zmdi-thumb-up'></i> Ok</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class='modal fade' tabindex='-1' role='dialog' id='Dialog-config'>
                <div class='modal-dialog' role='document'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                            <h4 class='modal-title'>Configuracion del calendario</h4>
                        </div>
                        <div class='modal-body'>
                          <form method='POST' autocomplete='off'>
                           
                            <div class='form-group'>
                                <div class='col-sm-12'>
                                    <div class='col-sm-4'>
                                        <label for='txtpassword' style='color:#009688'>Hora de incio</label>
                                        <input type='time' class='form-control' id='txtCalendarioInicio' name='txtCalendarioInicio' value='$horaInicio'  autocomplete='off'>
                                    </div>
                                    <div class='col-sm-4'>
                                        <label for='txtpasssword2' style='color:#009688'>Hora de fin</label>
                                        <input type='time' class='form-control' id='txtCalendarioFin' name='txtCalendarioFin' value='$horaFin'  autocomplete='off'>
                                    </div>
                                    <div class='col-sm-4'>
                                    <label for='txtpasssword2' style='color:#009688'>Duracion(minutos)</label>
                                    <input type='number' class='form-control' id='txtduracion' name='txtduracion' value='$duracion' min='5' max='60'  autocomplete='off'>
                                </div>
                                </div> 
                                <br><br><br><br>
                                <div class='col-sm-12'>
                                    <div class='col-sm-3'>
                                        <input type='checkbox' class='form-check-input' name='checkLunes' id='checkLunes' $lunes >
                                        <label class='form-check-label' for='materialUnchecked' >Lunes</label>
                                    </div>
                                    <div class='col-sm-3'>
                                        <input type='checkbox' class='form-check-input' name='checkMartes' id='checkMartes' $martes >
                                        <label class='form-check-label' for='materialUnchecked' >Martes</label>
                                    </div>
                                    <div class='col-sm-3'>
                                        <input type='checkbox' class='form-check-input' name='checkMiercoles' id='checkMiercoles' $miercoles>
                                        <label class='form-check-label' for='materialUnchecked'>Miercoles</label>
                                    </div>
                                    <div class='col-sm-3'>
                                        <input type='checkbox' class='form-check-input' name='checkJueves' id='checkJueves' $jueves>
                                        <label class='form-check-label' for='materialUnchecked'>Jueves</label>
                                    </div>
                                </div>
                                <div class='col-sm-12'>
                                    <div class='col-sm-3'>
                                        <input type='checkbox' class='form-check-input' name='checkViernes' id='checkViernes' $viernes>
                                        <label class='form-check-label' for='materialUnchecked'>Viernes</label>
                                    </div>
                                    <div class='col-sm-3'>
                                        <input type='checkbox' class='form-check-input' name='checkSabado' id='checkSabado' $sabado>
                                        <label class='form-check-label' for='materialUnchecked'>Sabado</label>
                                    </div>
                                    <div class='col-sm-3'>
                                        <input type='checkbox' class='form-check-input' name='checkDomingo' id='checkDomingo' $domingo>
                                        <label class='form-check-label' for='materialUnchecked'>Domingo</label>
                                    </div>
                                </div>
                                <br><br><br><br>
                            </div>
                            <div class='modal-footer'>
                                <button type='button' class='btn btn-danger btn-raised' data-dismiss='modal'><i class='zmdi zmdi-close'></i> Salir</button>
                                <button type='submit' class='btn btn-primary btn-raised' name='txtguardarcalendario' ><i class='zmdi zmdi-thumb-up'></i> Guardar</button>
                            </div>
                          </form> 
                        </div>
                       
                    </div>
                </div>
            </div>

       

    
        </body>
        </html>
        ";

        return $html;

    }

    public function abrirEspecial($titulo = "Parrot | Sistema de gestion"){
        $_clinica = new clinica;
        $nombreClinica = $_clinica->nombreClinica();
        $usuario = $_SESSION['Parrot']['Usuario'];

        $html = "
        <!DOCTYPE html>
        <html lang='es'>
        <head>
            <title>$titulo</title>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0'>
            <link rel='stylesheet' href='../theme/css/main.css'>
            <!--====== Scripts -->
            <script src='../theme/js/jquery-3.1.1.min.js'></script>
            <script src='../theme/js/bootstrap.min.js'></script>
            <script src='../theme/js/material.min.js'></script>
            <script src='../theme/alert/alertify.min.js'></script>
            <!-- <script src='../theme/js/afk.js'></script>-->
            <link rel='stylesheet' href='../theme/alert/css/alertify.min.css'>
            <link rel='stylesheet' href='../theme/alert/css/themes/bootstrap.min.css'>
        </head>
        <body>";

        return $html;
    }


    public function cerrarEspecial(){
        $html = "
        </body>
        </html>
        ";

        return $html;
    }


    public function checkLogin(){
        $url  = '../request/logincheck.php';
        $json = file_get_contents($url);
        return  $json;
    }

}



?>