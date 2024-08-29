<?php
require_once "../../database/conectar_db.php";
require_once "../../clase_materia.php"; 

if (isset($_POST['materia_nombre'])) {
    $materia = new Materia($_POST['materia_nombre']);
    $materia->crearMateria();
    header('Location: ../../materias.php?mensaje=creado');
    exit();
}
?>
