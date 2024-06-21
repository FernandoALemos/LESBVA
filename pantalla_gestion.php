<?php
    require_once "database\conectar_db.php";
    require_once "clase_materia.php";
    require_once "clase_usuario.php";
    require_once "clase_carrera.php";
    require_once "clase_cargo.php";
    require_once "clase_ciclo.php";
    require_once "clase_curso.php";
    require_once "clase_materia_carrera.php";
    require_once "clase_profesores.php";

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
    <style>
        header {font-size: 24px;height: 150px;width: 100%;height: 16vh;display: flex;align-items: center;justify-content: center;position: fixed;}
    </style>
</head>
<header>
    <img src="https://isfdyt24-bue.infd.edu.ar/sitio/wp-content/uploads/2020/07/logo-chico.png" alt="Instituto Superior de Formación Docente y Técnica Nº 24" style="float: left; margin-right: 10px; width: 100px; height: 100px;">
    <p class="header_div_nav-item">Instituto Superior de Formación Docente y Técnica Nº 24</p>
</header>
<main>

<body>
    <section id="Materias" class="divMaterias">
        <div class="divMaterias-cabecera">
            <button class="btn-descargar" onclick="location.href='pantalla_busqueda.php'">Volver</button>
            <div class="btns-space"></div>
        </div>
        <table class="lista">
            <!-- CARGOS -->
            <thead>
                <tr>
                    <th>TURNO</th>
                    <th>CARRERA</th>
                    <th>CAARGO</th>
                </tr>
            </thead>
            <tbody>
            <?php
                Cargo::listarCargos();
            ?>
            </tbody>
        </table>
        <br><br>
        <table class="lista">
            <!-- USUARIOS -->
            <thead>
                <tr>
                    <th>NOMBRE</th>
                    <th>APELLIDO</th>
                    <th>EMAIL</th>
                    <th>ROL</th>
                    <th>CARGO</th>
                    <th>SUSPENDIDO</th>
                </tr>
            </thead>
            <tbody>
            <?php
                Usuario::listarUsuarios();
            ?>
            </tbody>
        </table>
    </section>


</body>
</main>
<footer>
        <font-size="2"><h4><p class="titulos" ><font-size="2"></p><br>
        <p class="titulos"></p></h4></font-size>
    </footer>
</html>
