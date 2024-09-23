<?php
require_once "../../database/conectar_db.php";
require_once "../../clase_profesores.php"; 

$profesor_nombre = isset($_POST['profesor_nombre']) ? $_POST['profesor_nombre'] : null;
$profesor_apellido = isset($_POST['profesor_apellido']) ? $_POST['profesor_apellido'] : null;

if ($profesor_nombre && $profesor_apellido) {
    if (Profesor::verificarProfesor($profesor_nombre, $profesor_apellido)) {
        header("Location: ../../profesores.php?mensaje=prof_error");
    } 
    else {
        $profesor = new Profesor($profesor_nombre, $profesor_apellido);
        $profesor->crearProfesor();

        header("Location: ../../profesores.php?mensaje=creado");
    }
} 
else {
    echo "Error: faltan datos del profesor.";
}
?>
