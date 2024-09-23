<?php
require_once "database/conectar_db.php";
$con = conectar_db();

// 1. Ciclos (orden descendente)
$sql_ciclos = "SELECT DISTINCT cl.ciclo_id, cl.ciclo 
            FROM ciclo_lectivo cl 
            INNER JOIN materia_carrera mc ON mc.ciclo_id = cl.ciclo_id
            ORDER BY cl.ciclo DESC";
$resultado_ciclos = $con->query($sql_ciclos);
$ciclos = [];
while ($fila = $resultado_ciclos->fetch_assoc()) {
    $ciclos[] = ['id' => $fila['ciclo_id'], 'descripcion' => $fila['ciclo']];
}

// 2. Carreras (orden alfabético ascendente)
$sql_carreras = "SELECT DISTINCT c.carrera_id, c.carrera_nombre 
            FROM carreras c
            INNER JOIN materia_carrera mc ON mc.carrera_id = c.carrera_id
            ORDER BY c.carrera_nombre ASC";
$resultado_carreras = $con->query($sql_carreras);
$carreras = [];
while ($fila = $resultado_carreras->fetch_assoc()) {
    $carreras[] = ['id' => $fila['carrera_id'], 'descripcion' => $fila['carrera_nombre']];
}

// 3. Turnos (orden alfabético ascendente)
$sql_turnos = "SELECT DISTINCT t.turno_id, t.turno 
            FROM turnos t
            INNER JOIN materia_carrera mc ON mc.turno_id = t.turno_id
            ORDER BY t.turno ASC";
$resultado_turnos = $con->query($sql_turnos);
$turnos = [];
while ($fila = $resultado_turnos->fetch_assoc()) {
    $turnos[] = ['id' => $fila['turno_id'], 'descripcion' => $fila['turno']];
}

// 4. Cursos (orden alfabético ascendente)
$sql_cursos = "SELECT DISTINCT cr.curso_id, cr.curso 
            FROM cursos cr
            INNER JOIN materia_carrera mc ON mc.curso_id = cr.curso_id
            ORDER BY cr.curso ASC";
$resultado_cursos = $con->query($sql_cursos);
$cursos = [];
while ($fila = $resultado_cursos->fetch_assoc()) {
    $cursos[] = ['id' => $fila['curso_id'], 'descripcion' => $fila['curso']];
}

// 5. Profesores (orden alfabético por apellido)
$sql_profesores = "SELECT DISTINCT p.profesor_id, CONCAT(p.profesor_apellido, ' ', p.profesor_nombre) AS profesor_nombre_completo
                FROM profesores p
                INNER JOIN materia_carrera mc ON mc.profesor_id = p.profesor_id
                ORDER BY p.profesor_apellido ASC";
$resultado_profesores = $con->query($sql_profesores);
$profesores = [];
while ($fila = $resultado_profesores->fetch_assoc()) {
    $profesores[] = ['id' => $fila['profesor_id'], 'descripcion' => $fila['profesor_nombre_completo']];
}

$ciclos = array_values($ciclos);
$turnos = array_values($turnos);
$carreras = array_values($carreras);
$cursos = array_values($cursos);
$profesores = array_values($profesores);

$data = [
    'ciclos' => $ciclos,
    'turnos' => $turnos,
    'carreras' => $carreras,
    'cursos' => $cursos,
    'profesores' => $profesores
];

echo json_encode($data, JSON_UNESCAPED_UNICODE);
?>
