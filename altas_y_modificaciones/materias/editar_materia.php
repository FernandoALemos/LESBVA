<?php
require_once "../../database/conectar_db.php";
require_once "../../clase_materia.php"; 

if (isset($_POST['materia_id']) && isset($_POST['materia_nombre'])) {
    $materia = new Materia($_POST['materia_nombre']);
    $materia->modificarMateria($_POST['materia_id']);
    header('Location:  ../../materias.php?mensaje=editado');
    exit();
}
?>
