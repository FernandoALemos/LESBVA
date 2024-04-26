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
        <p class="titulos blanco"> </p>
</header>
<main>

<body>
    <section id="Materias" class="divMaterias">
        <div class="divMaterias-cabecera">
            <!-- <p class="titulos" >Administración de materias</p>
            <a href="pantalla_listar_materia.php?pan=1&acc=4#Matrequirederias" class="btn-ok ancora">Agregar nueva materia</a> -->
        </div>
        <table class="lista">
        <thead>
        <tr>
        <th>MATERIA</th>
        <th>GRADO</th>
        <th>CANT. ALUMNOS</th>
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
        <font-size="2"><h4><p class="titulos blanco" ><font-size="2"></p><br>
        <p class="titulos blanco"></p></h4></font-size>
    </footer>
</html>
