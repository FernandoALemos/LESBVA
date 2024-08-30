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
    <title>Reportes</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#ciclo').change(function() {
                var ciclo = $(this).val();
                if (ciclo) {
                    $.ajax({
                        type: 'POST',
                        url: 'get_turnos.php',
                        data: {
                            ciclo: ciclo
                        },
                        success: function(response) {
                            $('#turno').html(response);
                        }
                    });
                    $.ajax({
                        type: 'POST',
                        url: 'get_carreras.php',
                        data: {
                            ciclo: ciclo
                        },
                        success: function(response) {
                            $('#carrera').html(response);
                        }
                    });
                }
            });

            $('#carrera').change(function() {
                var carrera = $(this).val();
                $.ajax({
                    type: 'POST',
                    url: 'get_cursos.php',
                    data: {
                        carrera: carrera
                    },
                    success: function(response) {
                        $('#curso').html(response);
                    }
                });
            });

            $('#carrera').change(function() {
                var carrera = $(this).val();
                $.ajax({
                    type: 'POST',
                    url: 'get_profesores.php',
                    data: {
                        carrera: carrera
                    },
                    success: function(response) {
                        $('#profesor').html(response);
                    }
                });
            });
        });
    </script>
</head>
<header>
    <img src="https://isfdyt24-bue.infd.edu.ar/sitio/wp-content/uploads/2020/07/logo-chico.png" alt="Instituto Superior de Formación Docente y Técnica Nº 24" style="float: left; margin-right: 10px; width: 100px; height: 100px;">
    <p class="header_div_nav-item">Instituto Superior de Formación Docente y Técnica Nº 24</p>
</header>
<main>

    <body class=".bg-secondary.bg-gradient">
        <!-- <div class="divMaterias-cabecera"> -->
            <!-- <button class="btn-descargar" onclick="location.href='index.php'">Inicio</button>
        <div class="btns-space"></div> -->
        <!-- <button class="btn-descargar">Reportes</button> -->
     

        <!-- </div> -->
        <form action='informacion.php' class="presentacion" method="POST" style="display: flex; justify-content: center; flex-direction: row;">
            <div style="margin-right: 10px;">
                <?php
                $con = conectar_db();
                $sql_ciclo = "SELECT DISTINCT cl.ciclo FROM materia_carrera mc inner join ciclo_lectivo cl on mc.ciclo_id = cl.ciclo_id ORDER BY cl.ciclo DESC";
                $resultado_ciclo = $con->query($sql_ciclo);

                $ciclo = array();
                while ($fila = $resultado_ciclo->fetch_assoc()) {
                    $ciclo[] = $fila['ciclo'];
                }

                echo "<label for='ciclo'>Ciclo </label><br>";
                echo "<select name='ciclo' id='ciclo' required>";
                echo "<option value=''>Seleccione un ciclo</option>";
                foreach ($ciclo as $ciclos) {
                    echo "<option value='{$ciclos}'>{$ciclos}</option>";
                }
                echo "</select>";
                echo "<br>";

                echo "<br><label for='turno_id'>Turno </label><br>";
                echo "<select name='turno_id' id='turno' required>";
                echo "<option value=''>Seleccione un turno</option>";
                echo "</select>";
                echo "<br>";

                echo "<br><label for='carrera_id'>Carrera </label>";
                echo "<select name='carrera_id' id='carrera' required>";
                echo "<option value=''>Seleccione una carrera</option>";
                echo "</select>";
                echo "<br>";

                echo "<br><label for='curso_id'>Curso </label><br>";
                echo "<select name='curso_id' id='curso'>";
                echo "<option value=''>Seleccione un curso</option>";
                echo "</select>";
                echo "<br>";

                echo "<br><label for='profesor_id'>Profesor </label><br>";
                echo "<select name='profesor_id' id='profesor'>";
                echo "<option value=''>Seleccione un profesor</option>";
                echo "</select>";
                echo "<br>";

                echo "<br><input type='submit' class='btn-descargar' value='Continuar'>"; #Cambio estilo de boton, queda mejor.
                ?>
            </div>
        </form>
    </body>
</main>
<footer>
    <p class="titulos"><i class="fa-solid fa-arrow-right-from-bracket"> </i><a href="logout.php"> Cerrar sesión</a></p><br>
    <p class="titulos"><i class="fa-solid fa-house"> </i><a href="index.php"> Ir a inicio</a></p><br> <!-- Lo agrego acá, queda mejor que arriba de todo creo. -->
</footer>

</html>