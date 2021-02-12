<?php 
 require_once 'clases/usuarios.class.php';

$_usuarios= new usuarios;
$_usuarios->salir();

?>

<!DOCTYPE html>
<html lang="es">
<head>
	<title>LogIn</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="theme/css/main.css">

	<?php

			if(isset($_POST['btnlogin'])){
				$user  = $_POST['txtuser'];
				$password = $_POST['txtpassword'];
				$resp = $_usuarios->login($user,$password);
				if($resp){
					$datos = [
						'Usuario' => $resp[0]['Usuario'],
						'UsuarioId' => $resp[0]['UsuarioId'],
						'RolId' => $resp[0]['RolId'],
						'Estado' => $resp[0]['Estado'],
					];
					session_start();
					$_SESSION['Parrot'] = $datos;
					$datos = json_encode($datos);
					echo "<script>
						localStorage.setItem('userdata',JSON.stringify($datos));
					</script>";
					header("Location: vistas/calendario.php");
				}else{
						echo "
							<script>
								swal({
									title: 'Error',
									text: 'Error interno del servidor!!',
									icon: 'error',
									button: 'Ok!',
								});
							</script>
						";
				}
			}

		// echo "<script>
		//   let datos = localStorage.getItem('userdata');
		//    console.log(JSON.parse(datos))
		// </script>"
	?>
</head>
<body class="cover" style="background-image: url(theme/assets/img/fondo.jpg);">
	<form method="post" autocomplete="off" class="full-box logInForm">
		<p class="text-center text-muted"><i class="zmdi zmdi-account-circle zmdi-hc-5x"></i></p>
		<p class="text-center text-muted text-uppercase">Inicia sesión</p>
		<div class="form-group label-floating">
		  <label class="control-label" for="txtuser">Correo</label>
		  <input class="form-control" id="txtuser" name="txtuser" type="email" style="background-color:#FFF">
		  <p class="help-block">Escribe tú E-mail</p>
		</div>
		<div class="form-group label-floating">
		  <label class="control-label" for="txtpassword">Contraseña</label>
		  <input class="form-control" id="txtpassword" name="txtpassword" type="password" style="background-color:#FFF">
		  <p class="help-block">Escribe tú contraseña</p>
		</div>
		<div class="form-group text-center">
			<input type="submit" value="Iniciar sesión" class="btn btn-raised btn-success" name="btnlogin" id="btnlogin">
			<!-- <a href="vistas/calendario">Entrar</a> -->
		</div>
	</form>
	<!--====== Scripts -->
	<script src="theme/js/jquery-3.1.1.min.js"></script>
	<script src="theme/js/bootstrap.min.js"></script>
	<script src="theme/js/material.min.js"></script>
	<script src="theme/js/ripples.min.js"></script>
	<script src="theme/js/sweetalert2.min.js"></script>
	<script src="theme/js/jquery.mCustomScrollbar.concat.min.js"></script>
	<script src="theme/js/main.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</body>
</html>

