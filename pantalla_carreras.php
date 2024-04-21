<?php
    require_once "database\conectar_db.php";
    require_once "clase_materia.php";
    require_once "clase_usuario.php";
    require_once "clase_carrera.php";

    // session_start();
    // if(isset($_SESSION['rol_id']) && ($_SESSION['rol_id'] != 1 || $_SESSION['rol_id'] != 2)){
    //     die("No tenes credenciales para ingresar a este sitio. Intenta registrate</a>.");
    // }

    // $idSESION = $_SESSION['rol_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login2.css">
    <title>Bienvenido</title>
</head>
<header>
        <p class="titulos blanco">Seleccione la Carrera</p>
</header>
<main>

<body>
    <form class="presentacion" method="POST">
        <?php
            Carrera::mostrarNombresCarreras();
        ?>
    </form>


</body>
</main>
<footer>
        <font-size="2"><h4><p class="titulos blanco" ><font-size="2"></p><br>
        <p class="titulos blanco"></p></h4></font-size>
    </footer>
</html>
