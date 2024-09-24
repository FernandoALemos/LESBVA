<?php
require_once "../../database/conectar_db.php";
require_once "../../clase_ciclo.php"; 

$anio = isset($_POST['ciclo']) ? $_POST['ciclo'] : null;

if ($anio) {
    if (CicloLectivo::verificarCiclo($anio)) {
        header("Location: ../../ciclos_carreras_cursos.php?mensaje=cl_error");
    } 
    else {
        $ciclo = new CicloLectivo($anio);
        $ciclo->crearCiclo();
        header('Location: ../../ciclos_carreras_cursos.php?mensaje=ciclo_creado');
    }
} 
else {
    echo "Error: faltan datos del ciclo.";
}
?>
