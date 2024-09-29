<?php
require_once "../../database/conectar_db.php";
require_once "../../clase_materia_carrera.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $asignatura_id = intval($_POST['asignatura_id']); 
    $ciclo_id = intval($_POST['ciclo_id']);
    $carrera_id = intval($_POST['carrera_id']);
    $turno_id = intval($_POST['turno_id']);
    $curso_id = intval($_POST['curso_id']);
    $materia_id = intval($_POST['materia_id']);
    $profesor_id = intval($_POST['profesor_id']);
    $modulos = intval($_POST['modulos']);
    $situacion_revista = $_POST['situacion_revista'] ?? null;
    $inscriptos = intval($_POST['inscriptos']);
    $regulares = intval($_POST['regulares']);
    $atraso_academico = intval($_POST['atraso_academico']);
    $recursantes = intval($_POST['recursantes']);
    $primer_periodo = intval($_POST['primer_periodo']);
    $segundo_periodo = intval($_POST['segundo_periodo']);

    if (MateriaCarrera::verificarExistenciaAsignatura($ciclo_id, $carrera_id, $turno_id, $curso_id, $materia_id, $profesor_id, $asignatura_id)) {
        header("Location: ../../asignaturas.php?mensaje=error");
    } else {
        MateriaCarrera::modificarAsignatura(
            $asignatura_id, $ciclo_id, $carrera_id, $turno_id, $curso_id, $materia_id, 
            $profesor_id, $situacion_revista, $modulos, $inscriptos, $regulares, 
            $atraso_academico, $recursantes, $primer_periodo, $segundo_periodo
        );
        header("Location: ../../asignaturas.php?mensaje=editado");
    }
} else {
    echo "Error: faltan datos de la asignatura.";
}
?>
