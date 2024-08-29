<?php
require_once "../../database/conectar_db.php";
require_once "../../clase_ciclo.php"; 

if (isset($_POST['ciclo'])) {
    $ciclo = new CicloLectivo($_POST['ciclo']);
    $ciclo->crearCiclo();
    header('Location: ../../ciclos_carreras_cursos.php?mensaje=ciclo_creado');
    exit();
}
?>
