<?php
    require_once "database\conectar_db.php";
    require_once "clase_carrera.php";
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
        <p class="titulos blanco">Seleccione una materia</p>
</header>
<main>

<body>
    <form class="presentacion" method="post">
        <?php
            Carrera::listarCarreras();
        ?>
    </form>


</body>
</main>
<footer>
        <font-size="2"><h4><p class="titulos blanco" ><font-size="2"></p><br>
        <p class="titulos blanco"></p></h4></font-size>
    </footer>
</html>
