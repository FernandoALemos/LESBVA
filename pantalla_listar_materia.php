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
    <img src="https://isfdyt24-bue.infd.edu.ar/sitio/wp-content/uploads/2020/07/logo-chico.png" alt="Instituto Superior de Formación Docente y Técnica Nº 24" style="float: left; margin-right: 10px; width: 100px; height: 100px;">
    <p class="header_div_nav-item">Instituto Superior de Formación Docente y Técnica Nº 24</p>
</header>
<main>

<body>
    <section id="Materias" class="divMaterias">
        <div class="divMaterias-cabecera">
            <div class="btns-space"></div>
            <button class="btn-descargar">Descargar Excel</button>
        </div>
        <table class="lista">
            <thead>
                <tr>
                    <th>AÑO</th>
                    <th>CURSO</th>
                    <th>MATERIA</th>
                    <th>INSCRIPTOS</th>
                    <th>1° PERIODO</th>
                    <th>2° PERIODO</th>
                </tr>
            </thead>
            <tbody>
            <?php
                Materia::listarMaterias();
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
