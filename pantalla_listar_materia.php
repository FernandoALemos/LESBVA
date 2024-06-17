<?php
require_once "database\conectar_db.php";
require_once "clase_materia.php";
require_once "clase_usuario.php";
require_once "clase_carrera.php";
// require_once "clase_cargo.php"; Comento estos require ya que aún no existen y rompen el uso de la página
// require_once "clase_ciclo.php";
require_once "clase_curso.php";
require_once "clase_materia_carrera.php";
// require_once "clase_profesores.php";

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
    <title>Bienvenido</title>
    <style>
        header {
            font-size: 24px;
            height: 150px;
            width: 100%;
            height: 16vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: fixed;
        }
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
                <!-- <p class="header_div_nav-item">
                <?php
                // echo $_POST['ciclo']; "-" ; $_POST['carrera_nombre'];
                ?>
            </p>
            <div class="btns-space"></div> -->
                <button class="btn-descargar">Descargar Excel</button>
            </div>
            <table class="lista">
                <thead>
                    <tr>
                        <th>CICLO</th>
                        <th>CARRERA</th>
                        <th>CURSO</th>
                        <th>MATERIA</th>
                        <th>MODULOS</th>
                        <th>PROFESOR</th>
                        <th>SITUACIÓN DE REVISTA</th>
                        <th>INSCRIPTOS</th>
                        <th>REGULARES</th>
                        <th>ATRASO ACADEMICO</th>
                        <th>RECURSANTES</th>
                        <th>1° PERIODO</th>
                        <th>2° PERIODO</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // MateriaCarrera::listarMateriasCarrera();
                    $con = conectar_db();
                    $data = mysqli_query($con, "SELECT 
                    mc.materia_carrera_id,
                    m.materia_nombre,
                    c.carrera_nombre,
                    cl.ciclo,
                    cr.curso,
                    t.turno,
                    p.profesor_nombre,
                    p.profesor_apellido,
                    mc.situacion_revista,
                    mc.inscriptos,
                    mc.regulares,
                    mc.atraso_academico,
                    mc.recursantes,
                    mc.modulos,
                    mc.primer_periodo,
                    mc.segundo_periodo
                FROM 
                    materia_carrera mc
                JOIN 
                    materias m ON mc.materia_id = m.materia_id
                JOIN 
                    carreras c ON mc.carrera_id = c.carrera_id
                JOIN 
                    ciclo_lectivo cl ON mc.ciclo_id = cl.ciclo_id
                JOIN 
                    cursos cr ON mc.curso_id = cr.curso_id
                JOIN 
                    turnos t ON mc.turno_id = t.turno_id
                JOIN 
                    profesores p ON mc.profesor_id = p.profesor_id;
                ");


                    if (mysqli_affected_rows($con) == 0) {
                        echo "<tr><td><b class='bold red'>No hay materia_carrera registradas en el sistema</b></td></tr>";
                    } else {
                        while ($info = mysqli_fetch_assoc($data)) { ?>
                            <tr>
                                <td><?php echo $info['ciclo']; ?></td>
                                <td><?php echo $info['carrera_nombre']; ?></td>
                                <td><?php echo $info['curso']; ?></td>
                                <td><?php echo $info['materia_nombre']; ?></td>
                                <td><?php echo $info['modulos']; ?></td>
                                <td><?php echo $info['profesor_nombre'] . " " . $info['profesor_apellido']; ?></td> <!--VER PARA QUE SE INGRESE 1 O 2 PROFES -->
                                <td><?php echo $info['situacion_revista']; ?></td> <!--VER PARA QUE SE INGRESE 1 O 2 SITUCICONES SI HAY MAS PROFES -->
                                <td><?php echo $info['inscriptos']; ?></td>
                                <td><?php echo $info['regulares']; ?></td>
                                <td><?php echo $info['atraso_academico']; ?></td>
                                <td><?php echo $info['recursantes']; ?></td>
                                <td><?php echo $info['primer_periodo']; ?></td>
                                <td><?php echo $info['segundo_periodo']; ?></td>
                            </tr>
                    <?php   }
                    }
                    ?>
                </tbody>
            </table>
        </section>


    </body>
</main>
<footer>
    <font-size="2">
        <h4>
            <p class="titulos"><a href="logout.php">Cerrar sesión</a><font-size="2"></p><br> <!--Agrego para poder cerrar sesión-->
            <p class="titulos"></p>
        </h4></font-size>
</footer>

</html>