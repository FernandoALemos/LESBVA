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
        <form action='pantalla_listar_materia.php' class="presentacion" method="POST" style="display: flex; justify-content: center; flex-direction: row;">
            <div style="margin-right: 10px;">
                <?php
                $con = conectar_db();
                // Conexión a la base de datos (suponiendo que ya tienes esto configurado)
                // $sql_ciclo = "SELECT DISTINCT ciclo FROM ciclo_lectivo";
                $sql_ciclo = "SELECT DISTINCT cl.ciclo FROM materia_carrera mc inner join ciclo_lectivo cl on mc.ciclo_id = cl.ciclo_id";
                $resultado_ciclo = $con->query($sql_ciclo);

                $ciclo = array();
                while ($fila = $resultado_ciclo->fetch_assoc()) {
                    $ciclo[] = $fila['ciclo'];
                    // $carreras[$fila['carrera_nombre']][] = array('carrera_id' => $fila['carrera_id']);
                }

                // echo "<br> <form action='pantalla_listar_materia.php' method='POST'>";
                echo "<label for='ciclo'>Ciclo:     </label>";
                echo "<select name='ciclo'>";
                echo "<option value=''>Selecione un ciclo</option>";
                foreach ($ciclo as $ciclos) {
                    echo "<option value='{$ciclos}'>{$ciclos}</option>";
                }
                echo "</select>";
                // echo "</form> <br>";
                echo "<br>";

                // Carrera::filtrarCarreras();
                $sql_carrera = "SELECT carrera_id, carrera_nombre FROM carreras";
                $resultado_carrera = $con->query($sql_carrera);

                $carrera = array();
                while ($fila = $resultado_carrera->fetch_assoc()) {
                    $carrera[] = $fila['carrera_nombre'];
                    $carreras[$fila['carrera_nombre']][] = array('carrera_id' => $fila['carrera_id']);
                }

                // echo "<br> <form action='pantalla_busqueda.php' method='POST'>";
                echo "<br><label for='carrera_nombre'>Carrera:     </label>";
                echo "<select name='carrera_nombre'>";
                echo "<option value=''>Seleccione una carrera</option>";
                foreach ($carrera as $nombre_carrera) {
                    echo "<option value='{$nombre_carrera}'>{$nombre_carrera}</option>";
                }
                echo "</select>";

                // echo "</form> <br>";
                echo "<br>";


                // Curso::filtrarCurso();
                $sql_curso = "SELECT DISTINCT curso FROM cursos";
                $resultado_curso = $con->query($sql_curso);

                // Almacenar los años de cursos en un array asociativo
                $cursos_cursos = array();
                while ($fila = $resultado_curso->fetch_assoc()) {
                    $cursos_cursos[] = $fila['curso'];
                }

                // Mostrar el formulario con las opciones
                // echo "<form action='pantalla_listar_materia.php' method='POST'>";
                echo "<br><label for='curso'>Curso:      </label>";
                echo "<select name='curso'>";
                echo "<option value=''>Seleccione un curso</option>";
                foreach ($cursos_cursos as $curso) {
                    echo "<option value='{$curso}'>{$curso}</option>";
                }
                echo "</select>";

                // VER SI ESTO HACE QUE TENGA POST PARA ESTE QUERY (VER EN CICLO Y CARRERAS)
                echo "<br><input type='submit' class='button' value='Continuar' 
                >";
                echo "</form>";
                ?>
            </div>

        </form>
    </body>
</main>
<footer>
    <p class="titulos"><a href="logout.php">Cerrar sesión</a><font-size="2"></p><br> <!--Agrego para poder cerrar sesión-->
    <p class="titulos"></p>
    </h4></font-size>
</footer>

</html>