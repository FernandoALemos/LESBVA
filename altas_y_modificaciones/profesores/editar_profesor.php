<?php
require_once "../../database/conectar_db.php";
require_once "../../clase_profesores.php"; 

$profesor_id = isset($_POST['profesor_id']) ? $_POST['profesor_id'] : null;
$profesor_nombre = isset($_POST['profesor_nombre']) ? $_POST['profesor_nombre'] : null;
$profesor_apellido = isset($_POST['profesor_apellido']) ? $_POST['profesor_apellido'] : null;
$profesor_dni = isset($_POST['profesor_dni']) ? $_POST['profesor_dni'] : null;
$profesor_email = isset($_POST['profesor_email']) ? $_POST['profesor_email'] : null;
$profesor_direccion = isset($_POST['profesor_direccion']) ? $_POST['profesor_direccion'] : null;
$profesor_telefono = isset($_POST['profesor_telefono']) ? $_POST['profesor_telefono'] : null;
$profesor_activo = isset($_POST['profesor_activo']) ? $_POST['profesor_activo'] : null;

if (Profesor::verificarProfesor($profesor_dni, $profesor_id)) {
    header("Location: ../../profesores.php?mensaje=prof_error");
} 
else {
    $profesor = new Profesor($profesor_nombre, $profesor_apellido, $profesor_dni, $profesor_email, $profesor_direccion, $profesor_telefono, $profesor_activo);
    $profesor->modificarProfesor($profesor_id);
    header("Location: ../../profesores.php?mensaje=editado");
}

?>
