<?php
require_once "../../database/conectar_db.php";
require_once "../../clase_materia_carrera.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ciclo_id = $_POST['ciclo_id'];
    $carrera_id = $_POST['carrera_id'];
    $turno_id = $_POST['turno_id'];
    $curso_id = $_POST['curso_id'];
    $materia_id = $_POST['materia_id'];
    $profesor_id = $_POST['profesor_id'];
    $modulos = $_POST['modulos'];
    $situacion_revista = $_POST['situacion_revista'];
    $inscriptos = $_POST['inscriptos'];
    $regulares = $_POST['regulares'];
    $atraso_academico = $_POST['atraso_academico'];
    $recursantes = $_POST['recursantes'];
    $primer_periodo = $_POST['primer_periodo'];
    $segundo_periodo = $_POST['segundo_periodo'];

    // echo $ciclo_id." | ".$carrera_id." | ".$turno_id." | ".$curso_id." | ".$materia_id." | ".$profesor_id." | ".$situacion_revista." | ".$modulos." | ".$inscriptos." | ".$regulares." | ".$atraso_academico." | ".$recursantes." | ".$primer_periodo." | ".$segundo_periodo;

    if (MateriaCarrera::verificarExistenciaAsignatura($ciclo_id, $carrera_id, $turno_id, $curso_id, $materia_id, $profesor_id)) {
        header("Location: ../../form_crear_asignatura.php?mensaje=error");
    } 
    else {
        MateriaCarrera::crearAsignatura(
            $ciclo_id, $carrera_id, $turno_id, $curso_id, $materia_id, $profesor_id, 
            $situacion_revista, $modulos, $inscriptos, $regulares, 
            $atraso_academico, $recursantes, $primer_periodo, $segundo_periodo
        );
        header("Location: ../../form_crear_asignatura.php?mensaje=creado");
    }
} else {
    echo "Error: faltan datos de la asignatura.";
}

?>

