<?php
require_once "../../database/conectar_db.php";
require_once "../../clase_carrera.php"; 

$carrera_nombre = isset($_POST['carrera_nombre']) ? $_POST['carrera_nombre'] : null;
$carrera_id = isset($_POST['carrera_id']) ? $_POST['carrera_id'] : null;

if ($carrera_nombre) {
    if (Carrera::verificarCarrera($carrera_nombre)) {
        header("Location: ../../ciclos_carreras_cursos.php?mensaje=ca_error");
    } 
    else {
        $carrera = new Carrera($carrera_nombre);
        $carrera->modificarCarrera($carrera_id);

        header('Location: ../../ciclos_carreras_cursos.php?mensaje=carrera_editada');
    }
} 
else {
    echo "Error: faltan datos de la materia.";
}

?>
