<?php
require_once "database\conectar_db.php";

$con = conectar_db();

$id = $con->real_escape_string($_POST['id']);
// $_POST['id'] = $asignatura['materia_carrera_id'] no reconoce el id

echo $id;

$sql = "SELECT mc.*, 
            m.materia_nombre, 
            c.carrera_nombre, 
            cl.ciclo, 
            cr.curso, 
            t.turno, 
            p.profesor_nombre, 
            p.profesor_apellido,
            mc.situacion_revista,
            mc.inscriptos,
            mc.regulares,
            mc.atraso_academico,
            mc.recursantes,
            mc.modulos,
            mc.primer_periodo,
            mc.segundo_periodo
    FROM materia_carrera mc
    JOIN materias m ON mc.materia_id = m.materia_id
    JOIN carreras c ON mc.carrera_id = c.carrera_id
    JOIN ciclo_lectivo cl ON mc.ciclo_id = cl.ciclo_id
    JOIN cursos cr ON mc.curso_id = cr.curso_id
    JOIN turnos t ON mc.turno_id = t.turno_id
    JOIN profesores p ON mc.profesor_id = p.profesor_id
    WHERE mc.materia_carrera_id = $id LIMIT 1";

$resultado = $con->query($sql);
$rows = $resultado->num_rows;

$asignatura = [];

if ($rows > 0) {
    $asignatura = $resultado->fetch_array();
}

echo json_encode($asignatura, JSON_UNESCAPED_UNICODE);


?>
