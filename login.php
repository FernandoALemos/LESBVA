<?php 
    
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login.css">
    <script src="https://kit.fontawesome.com/600e7f7446.js" crossorigin="anonymous"></script>
    <title>Iniciar sesión</title> <!-- Cambio Mati -->

</head>

<body>
    <header>
        <div>
            <!-- <nav>
                <div>
                <a href="index.php" class="header_div_nav-item">Inicio</a>
                <div>
            </nav> -->
        </div>
    </header>
    <main>
        <div class="contenedorLogin">
            <form class="contenedorLogin-form" method="POST">
                <label class="contenedorLogin_form-label" for="dni">
                    Ingrese su dni
                    <input class="contenedorLogin_form_label-input" type="number" name="dni" id="dni" placeholder="Ingrese su DNI" maxlength="8" required> <!-- modificado Mati el placeholder-->
                </label>
                <label class="contenedorLogin_form-label" for="contra">
                    Ingrese su contraseña
                    <input class="contenedorLogin_form_label-input" type="password" name="contrasenia" id="contra" placeholder="Ingrese su contraseña" required> <!-- modificado Mati el placeholder-->
                </label>
                <div class="contenedorLogin_form-cajaBtn">
                    <button class="btn-ok" type="submit">Acceder</button>
                </div>
            </form>
            <div class="contenedorLogin-cajaMensaje">
                <p class="contenedorLogin_cajaMensaje-Texto">
                    <?php 
                        if( isset($_POST['dni']) )
                            Usuario::VerificarUsuario($_POST['dni'],$_POST['contrasenia'])
                    ?>
                </p>
            </div>
        </div>
    </main>
    <footer>
        <font-size="5"><h4><p class="titulos blanco" ><font-size="5"></p><br>
        <p class="titulos blanco"></p></h4></font-size>
    </footer>
</body>

</html>
