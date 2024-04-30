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
    <form class="presentacion" method="POST" style="display: flex; justify-content: center; flex-direction: row;">
        <div style="margin-right: 10px;">
            <?php
                $con = conectar_db();
                // Conexión a la base de datos (suponiendo que ya tienes esto configurado)
                $sql = "SELECT DISTINCT anio_lectivo FROM ciclo_lectivo";
                $resultado = $con->query($sql);
    
                $ciclo = array();
                while ($fila = $resultado->fetch_assoc()) {
                    $ciclo[] = $fila['anio_lectivo'];
                    // $carreras[$fila['carrera_nombre']][] = array('carrera_id' => $fila['carrera_id']);
                }
    
                echo "<br> <form action='pantalla_busqueda.php' method='POST'>";
                echo "<label for='anio_lectivo'>AÑO:     </label>";
                echo "<select name='anio_lectivo'>";
                echo "<option value=''>Todos</option>";
                foreach ($ciclo as $ciclos) {
                    echo "<option value='{$ciclos}'>{$ciclos}</option>";
                }
                echo "</select>";
                echo "</form> <br>";
                Carrera::mostrarNombresCarreras();
                Materia::filterAño();
                Materia::filterMateria();
            ?>
        </div>
        
    </form>
</body>
</main>
<footer>
        <font-size="2"><h4><p class="titulos" ><font-size="2"></p><br>
        <p class="titulos"></p></h4></font-size>
    </footer>
</html>
