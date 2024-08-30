<?php
require_once "database\conectar_db.php";
require_once "clase_materia.php";
require_once "clase_usuario.php";
require_once "clase_carrera.php";
require_once "clase_curso.php";
require_once "clase_materia_carrera.php";


session_start();
if (!isset($_SESSION['rol_id']) || $_SESSION['rol_id'] <> 1) { //Acá solo lo limito para que solo el director entre hasta que definamos todas las pantallas.
    echo "<h1>Usted no posee permisos para utilizar esta página</h1>";
    echo "<br><a href='login.php'>Ir a inicio</a>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Inicio</title>
</head>
<header>
    <img src="https://isfdyt24-bue.infd.edu.ar/sitio/wp-content/uploads/2020/07/logo-chico.png" alt="Instituto Superior de Formación Docente y Técnica Nº 24" style="float: left; margin-right: 10px; width: 100px; height: 100px;">
    <p class="header_div_nav-item">Instituto Superior de Formación Docente y Técnica Nº 24</p>
</header>
<main>

    <body>
        <nav>

            <ul>
                <button class="btn-descargar" onclick="location.href='ciclos_carreras_cursos.php'"><i class="fa-solid fa-rectangle-list"> </i> Ciclos/Carreras/Cursos</button>
            </ul>

            <ul>
                <button class="btn-descargar" onclick="location.href='materias.php'"><i class="fa-solid fa-file-signature"> </i> Unidad Curricular</button>
            </ul>

            <ul>
                <button class="btn-descargar" onclick="location.href='profesores.php'"><i class="fa-solid fa-user-graduate"> </i> Profesores</button>
            </ul>

            <ul>
                <button class="btn-descargar" onclick="location.href='buscador.php'"><i class="fa-solid fa-chart-line"> </i> Reportes</button>
            </ul>

            <ul>
                <button class="btn-descargar" onclick="location.href='form_crear_asignatura.php'"><i class="fa-solid fa-list-check"> </i> Asignaciones</button>
            </ul>

            <ul>
                <button class="btn-descargar" onclick="location.href='usuarios.php'"><i class="fa-solid fa-user"> </i> Usuarios</button>
            </ul>

        </nav>
    </body>
</main>
<footer>
    <p class="titulos"><i class="fa-solid fa-arrow-right-from-bracket"> </i><a href="logout.php"> Cerrar sesión</a></p><br>
</footer>

</html>