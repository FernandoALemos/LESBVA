<?php 
    
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/600e7f7446.js" crossorigin="anonymous"></script>
    <title>Titulo</title>

</head>

<body>
    <header>
        <div>
            <nav>
                <div>
                <a href="index.php" class="header_div_nav-item">Inicio</a>
                <div>
            </nav>
        </div>
    </header>
    <main>
        <div>
            <form  method="POST">
                <label  for="dni">
                    Ingrese su dni
                    <input  type="number" name="dni" id="dni" placeholder="00000000" maxlength="8" required>
                </label>
                <label for="contra">
                    Ingrese su contraseña
                    <input  type="password" name="contrasenia" id="contra" placeholder="***********" required>
                </label>
                <div c>
                    <button  type="submit">Acceder</button>
                </div>
            </form>
            <div >
                <p>
                    <?php 
                        if( isset($_POST['dni']) )
                            Usuario::VerificarUsuario($_POST['dni'],$_POST['contrasenia'])
                    ?>
                </p>
            </div>
        </div>
    </main>
    <footer>

    </footer>
</body>

</html>