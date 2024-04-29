<?php
    require_once "database\conectar_db.php";
    require_once "clase_materia.php";
    require_once "clase_usuario.php";
    require_once "clase_carrera.php";

    // session_start();

    // if(isset($_SESSION['rol_id'])){
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
    <link rel="stylesheet" href="css/login.css">
    <title>Bienvenido</title>
</head>
<header>
        <!-- <p class="titulos blanco"> </p> -->
        <title>Estudiar en Instituto Superior de Formación Docente y Técnica Nº 24</title>
</header>
<main>

<body>
    <form class="presentacion" method="POST" style="display: flex; justify-content: center; flex-direction: row;">
        <div style="margin-right: 10px;">
            <?php
                Carrera::mostrarNombresCarreras();
                Materia::filterAño();
                Materia::filterMateria();
            ?>
        </div>
        
    </form>
</body>
</main>
<footer>
        <font-size="2"><h4><p class="titulos blanco" ><font-size="2"></p><br>
        <p class="titulos blanco"></p></h4></font-size>
    </footer>
</html>
