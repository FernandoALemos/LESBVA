<?php
require_once "../../database/conectar_db.php";
require_once "../../clase_carrera.php"; 

if (isset($_POST['carrera_id']) && isset($_POST['carrera_nombre'])) {
    $carrera = new Carrera($_POST['carrera_nombre']);
    $carrera->modificarCarrera($_POST['carrera_id']);
    header('Location:  ../../ciclos_carreras_cursos.php?mensaje=carrera_editada');
    exit();
}
?>
