<?php
require_once "../../database/conectar_db.php";
require_once "../../clase_profesores.php"; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $profesor_id = $_POST['profesor_id'];
    $profesor_nombre = $_POST['profesor_nombre'];
    $profesor_apellido = $_POST['profesor_apellido'];
    $profesor_dni = intval($_POST['profesor_dni']);
    $profesor_email = $_POST['profesor_email'];
    $profesor_telefono = $_POST['profesor_telefono'];
    $profesor_direccion = $_POST['profesor_direccion'];
    $profesor_activo = $_POST['profesor_activo'];

    if (Profesor::verificarProfesor($profesor_dni, $profesor_id)) {
        header("Location: ../../profesores.php?mensaje=prof_error");
    } 
    else {
        $profesor = new Profesor($profesor_nombre, $profesor_apellido, $profesor_dni, $profesor_email, $profesor_direccion, $profesor_telefono, $profesor_activo);
        $profesor->modificarProfesor($profesor_id);
        header("Location: ../../profesores.php?mensaje=editado");
    }
}
else {
    echo "Error: faltan datos del profesor.";
}

?>
