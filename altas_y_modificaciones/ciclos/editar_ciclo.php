<?php
require_once "../../database/conectar_db.php";
require_once "../../clase_ciclo.php"; 

$anio = isset($_POST['ciclo']) ? $_POST['ciclo'] : null;
$ciclo_id = isset($_POST['ciclo_id']) ? $_POST['ciclo_id'] : null;

if ($anio) {
    if (CicloLectivo::verificarCiclo($anio)) {
        header("Location: ../../ciclos_carreras_cursos.php?mensaje=cl_error");
    } 
    else {
        $ciclo = new CicloLectivo($anio);
        $ciclo->modificarCiclo($ciclo_id);
        header('Location: ../../ciclos_carreras_cursos.php?mensaje=ciclo_editado');
    }
} 
else {
    echo "Error: faltan datos del ciclo.";
}

?>
