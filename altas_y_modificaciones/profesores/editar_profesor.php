<?php
require_once "../../database/conectar_db.php";
require_once "../../clase_profesores.php"; 

if (isset($_POST['profesor_id']) && isset($_POST['profesor_nombre']) && isset($_POST['profesor_apellido'])) {
    $profesor = new Profesor($_POST['profesor_nombre'], $_POST['profesor_apellido']);
    $profesor->modificarProfesor($_POST['profesor_id']);
    header('Location:  ../../profesores.php?mensaje=editado');
    exit();
}
?>
