<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos/style.css">
    <title>Fin de sesión</title>
</head>

<body>

    <?php

    session_start();
    session_destroy();
    ?>
    <div class="asignar una clase">
        <form action="login.php" method="post">
            <h1>Sesión finalizada</h1>
            <br><br><input type="submit" class="btn" value="Ir a inicio">
    </div>

</body>

</html>