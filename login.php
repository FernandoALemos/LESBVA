<?php 
    require_once "database\conectar_db.php";
    require_once "clase_usuario.php";
	// CREAR CLASES PROFE, CURSO, CARGO, CICLO

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
	<link rel="stylesheet" type="text/css" href="css/login2.css">
	<link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">

</head>


<body class="body-img">
	<div class="main">  	
		<input type="checkbox" id="chk" aria-hidden="true">

			<div class="signup">
				<img src="https://isfdyt24-bue.infd.edu.ar/sitio/wp-content/uploads/2020/07/logo-chico.png" alt="Instituto Superior de Formación Docente y Técnica Nº 24" style="float: left; margin-right: 10px; width: 100px; height: 100px;">
				<form>
					<label for="chk" aria-hidden="true">Bienvenido</label>
				</form>
			</div>

			<div class="login">
				<form method="POST">
					<label for="chk" aria-hidden="true">Iniciar Sesión</label>
					<input type="text" name="email" id="email" placeholder="Ingresar Email" required>
					<input type="password" name="contrasenia" id="contra" placeholder="Contraseña" required>
					<button>Acceder</button>
				</form>
			</div>
	</div>

	<?php 
		if( isset($_POST['email']) )
			Usuario::VerificarUsuario($_POST['email'],$_POST['contrasenia'])
	?>



</body>

</html>
