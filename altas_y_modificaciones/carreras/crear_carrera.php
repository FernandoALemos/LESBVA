<?php
require_once "../../database/conectar_db.php";
require_once "../../clase_carrera.php"; 

if (isset($_POST['carrera_nombre'])) {
    $carrera = new Carrera($_POST['carrera_nombre']);
    $carrera->crearCarrera();
    header('Location: ../../ciclos_carreras_cursos.php');
}
?>
