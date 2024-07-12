<?php
require_once "database\conectar_db.php";
require_once "clase_materia.php";
require_once "clase_usuario.php";
require_once "clase_carrera.php";
require_once "clase_curso.php";
require_once "clase_materia_carrera.php";
require_once "clase_profesores.php";


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
    <title>Crear profesor</title>
</head>
<header>
    <img src="https://isfdyt24-bue.infd.edu.ar/sitio/wp-content/uploads/2020/07/logo-chico.png" alt="Instituto Superior de Formación Docente y Técnica Nº 24" style="float: left; margin-right: 10px; width: 100px; height: 100px;">
    <p class="header_div_nav-item">Instituto Superior de Formación Docente y Técnica Nº 24</p>
</header>
<main>

    <body>
        <div class="divMaterias-cabecera">
            <button class="btn-descargar" onclick="location.href='index.php'">Inicio</button>
                <div class="btns-space"></div>
            <!-- <button class="btn-descargar">Editar</button> -->
        </div>
        <br> <br>
        <form action="crearprofesor.php" method="post">
            <p>Ingrese el nombre: <input type="text" name="profesor_nombre" id="profesor_nombre" required></p><br>
            <p>Ingrese el apellido: <input type="text" name="profesor_apellido" id="profesor_apellido" required></p>
            <input type="submit" class="button" value="Crear"><br><br><br>
        </form>
        <!-- <a href="index.php" class="btn-descargar">Volver a inicio</a> -->
        <!-- <div>
        <button class="button" onclick="location.href='index.php'">Volver</button>
        </div> -->
        <?php
        if (isset($_POST['profesor_nombre'])) {
            $profesor = new Profesor($_POST['profesor_nombre'], $_POST['profesor_apellido']);
            $profesor->crearProfesor();
        }
        ?>
        <section id="Profesores" class="divProfesores">
            <div class="divProfesores-cabecera">
                <!-- <a class="btn-ok ancora">Nueva Profesor</a> -->
            </div>
            <table class="lista">
            <thead>
                <tr>
                    <th>Apellido</th>
                    <th>Nombre</th>
                    <th>Modificar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    Profesor::listarProfesores();
                ?>
            </tbody>
            </table>
        </section>
    </body>
</main>
<footer>
    <p class="titulos"><i class="fa-solid fa-arrow-right-from-bracket"></i><a href="logout.php">Cerrar sesión</a></p><br>
</footer>

</html>