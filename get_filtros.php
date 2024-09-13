<?php
require_once "database/conectar_db.php";
$con = conectar_db();

$ciclo = $_POST['ciclo'] ?? '';
$carrera = $_POST['carrera'] ?? '';
$turno = $_POST['turno'] ?? '';
$curso = $_POST['curso'] ?? '';
$profesor = $_POST['profesor'] ?? '';

$where_clauses = [];
if (!empty($ciclo)) {
    $where_clauses[] = "mc.ciclo_id = '$ciclo'";
}
if (!empty($carrera)) {
    $where_clauses[] = "mc.carrera_id = '$carrera'";
}
if (!empty($turno)) {
    $where_clauses[] = "mc.turno_id = '$turno'";
}
if (!empty($curso)) {
    $where_clauses[] = "mc.curso_id = '$curso'";
}
if (!empty($profesor)) {
    $where_clauses[] = "mc.profesor_id = '$profesor'";
}

$where_sql = '';
if (!empty($where_clauses)) {
    $where_sql = 'WHERE ' . implode(' AND ', $where_clauses);
}

$sql_filtros = "SELECT DISTINCT cl.ciclo_id, cl.ciclo, c.carrera_id, c.carrera_nombre, t.turno_id, t.turno, cr.curso_id, cr.curso, p.profesor_id, CONCAT(p.profesor_apellido, ' ', p.profesor_nombre) AS profesor_nombre_completo
    FROM materia_carrera mc
    INNER JOIN ciclo_lectivo cl ON mc.ciclo_id = cl.ciclo_id
    INNER JOIN turnos t ON mc.turno_id = t.turno_id
    INNER JOIN carreras c ON mc.carrera_id = c.carrera_id
    INNER JOIN cursos cr ON mc.curso_id = cr.curso_id
    INNER JOIN profesores p ON mc.profesor_id = p.profesor_id
    $where_sql
    ORDER BY cl.ciclo, c.carrera_nombre, t.turno, cr.curso, p.profesor_apellido";


$resultado_filtros = $con->query($sql_filtros);
$ciclos = $turnos = $carreras = $cursos = $profesores = [];

while ($fila = $resultado_filtros->fetch_assoc()) {
    if (!array_key_exists($fila['ciclo_id'], $ciclos)) {
        $ciclos[$fila['ciclo_id']] = [
            'id' => $fila['ciclo_id'],
            'descripcion' => $fila['ciclo']
        ];
    }

    if (!array_key_exists($fila['turno_id'], $turnos)) {
        $turnos[$fila['turno_id']] = [
            'id' => $fila['turno_id'],
            'descripcion' => $fila['turno']
        ];
    }

    if (!array_key_exists($fila['carrera_id'], $carreras)) {
        $carreras[$fila['carrera_id']] = [
            'id' => $fila['carrera_id'],
            'descripcion' => $fila['carrera_nombre']
        ];
    }

    if (!array_key_exists($fila['curso_id'], $cursos)) {
        $cursos[$fila['curso_id']] = [
            'id' => $fila['curso_id'],
            'descripcion' => $fila['curso']
        ];
    }

    if (!array_key_exists($fila['profesor_id'], $profesores)) {
        $profesores[$fila['profesor_id']] = [
            'id' => $fila['profesor_id'],
            'descripcion' => $fila['profesor_nombre_completo']
        ];
    }
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
