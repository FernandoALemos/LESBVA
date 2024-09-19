<?php
require_once "../../database/conectar_db.php";
require_once "../../clase_cargo.php";

$carrera_id = isset($_POST['carrera_id']) ? $_POST['carrera_id'] : null;
$turno_id = isset($_POST['turno_id']) ? $_POST['turno_id'] : null;
$cargo_nombre = isset($_POST['cargo_nombre']) ? $_POST['cargo_nombre'] : null;

if ($carrera_id && $turno_id && $cargo_nombre) {
    if (Cargo::verificarExistenciaCargo($carrera_id, $turno_id, $cargo_nombre)) {
        header("Location: ../../usuarios.php?mensaje=cargo_error");
    } else {
        
        $cargo = new Cargo($carrera_id, $turno_id, $cargo_nombre);
        $cargo->crearCargo();

        header("Location: ../../usuarios.php?mensaje=cargo_creado");
    }
} else {
    echo "Error: faltan datos del cargo.";
}
?>
