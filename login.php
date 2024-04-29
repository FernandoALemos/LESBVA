<?php 
    require_once "database\conectar_db.php";
    require_once "clase_usuario.php";

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

<body>
    <header>
        <div>

        </div>
    </header>
	<div class="main">  	
		<input type="checkbox" id="chk" aria-hidden="true">

			<div class="signup">
				<form>
					<label for="chk" aria-hidden="true">Bienvenido</label>
				</form>
			</div>

			<div class="login">
				<form method="POST">
					<label for="chk" aria-hidden="true">Iniciar Sesión</label>
					<input type="number" name="dni" id="dni" placeholder="Ingrese su DNI" required="">
					<input type="password" name="contrasenia" id="contra" placeholder="Contraseña" required="">
					<button>Acceder</button>
				</form>
			</div>
	</div>

                    <?php 
                        if( isset($_POST['dni']) )
                            Usuario::VerificarUsuario($_POST['dni'],$_POST['contrasenia'])
                    ?>


    </main>

</body>

</html>
